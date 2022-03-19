<?php

namespace App\Repositories;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\isNull;

class IsmailRepository {

/*-----------------------méthodes pour la page informations personnelles-------------------*/

    //afficher les infos personnelles pour les conducteurs et les passagers
    function infoPersonnelles(int $idUtilisateur): array
    {
        $infoPerso =  DB::table('Utilisateurs')
            ->where('idUtilisateur', $idUtilisateur)
            ->get()
            ->toArray();
        if (count($infoPerso) == 0){
            throw new Exception("L'utilisateur inconnu");
        }
        return $infoPerso;
    }
    //afficher les infos techniques pour les conducteurs uniquement
    function estConducteur(int $idUtilisateur): bool
    {
        $condcuteurs = DB::table('Utilisateurs')
                ->join('Voitures', 'Utilisateurs.idUtilisateur', '=', 'Voitures.idUtilisateur')
                ->where('Voitures.idUtilisateur', $idUtilisateur)
                ->get('Voitures.*')
                ->toArray();
        return count($condcuteurs) != 0;
    }
    function infoTechniques(int $idUtilisateur): array
    {
        $infoTechnique =  DB::table('Utilisateurs')
                ->join('Voitures', 'Utilisateurs.idUtilisateur', '=', 'Voitures.idUtilisateur')
                ->where('Voitures.idUtilisateur', $idUtilisateur)
                ->get('Voitures.*')
                ->toArray();
        if (count($infoTechnique) == 0){
            throw new Exception("Vous n'êtes pas conducteur");
        }
        return $infoTechnique;   
    }
    //calculer le nombre de trajet en tant que passager
    function nbrTrajetPassager(int $idUtilisateur): int
    {
        $nbrTrajetPassager = DB::table('Utilisateurs')
            ->join('Reservations', 'Utilisateurs.idUtilisateur', '=', 'Reservations.idPassager')
            ->where('Reservations.idPassager', $idUtilisateur)
            ->get()
            ->toArray();
        return count($nbrTrajetPassager);
    } 
    //calculer le nombre de trajet en tant que conducteur
    function nbrTrajetConducteur(int $idUtilisateur) : int
    {
        $nbrTrajetConducteur = DB::table('Voitures')
            ->join('Trajets', 'Voitures.immatriculation', '=', 'Trajets.immatriculation')
            ->where('idUtilisateur', $idUtilisateur)
            ->get()
            ->toArray();
        return count($nbrTrajetConducteur);
    }


/*-----------------------Méthodes pour la page mes trajets en cours-------------------*/
    // les trajets en cours du conducteur
    function trajetEnCours(int $idConducteur): array
    {    
        $trajetsEnCours =  DB::table('Trajets')
                            ->join('Lieux as lieuD', 'Trajets.idLieuDepart', '=', 'lieuD.idLieu')
                            ->join('Lieux as lieuA', 'Trajets.idLieuArrivee', '=', 'lieuA.idLieu')
                            ->join('Voitures', 'Trajets.immatriculation', '=', 'Voitures.immatriculation')
                            ->join('Utilisateurs', 'Voitures.idUtilisateur', '=', 'Utilisateurs.idUtilisateur')
                            ->where('Voitures.idUtilisateur', $idConducteur)
                            ->where('Trajets.dateHeureArrivee', '>', NOW())
                            ->orderBy('Trajets.dateHeureDepart')
                            ->get(['Trajets.*', 'lieuD.numRue as numRueDep', 'lieuD.adresseRue as rueDep', 'lieuD.ville as villeDep',
                                    'lieuD.cP as cpDep', 'lieuA.numRue as numRueArr', 'lieuA.adresseRue as rueArr', 'lieuA.ville as villeArr',
                                    'lieuA.cP as cpArr', 'Utilisateurs.prenomUtilisateur', 'Utilisateurs.nomUtilisateur',
                                    'Utilisateurs.photoProfil', 'Utilisateurs.idUtilisateur'])
                            ->toArray();
                            
        if (count($trajetsEnCours) == 0){
            throw new Exception("Vous n'êtes pas conducteur");
        }
        return $trajetsEnCours;
    } 
    //tous les passager réservés dans un trajet
    function passagersDuTrajet(int $idTrajet): array
    {
        $passagers =  DB::table('Trajets')
            ->join('Reservations', 'Trajets.idTrajet', '=', 'Reservations.idTrajet')
            ->join('Utilisateurs', 'Utilisateurs.idUtilisateur', '=', 'Reservations.idPassager')
            ->where('Reservations.idTrajet',$idTrajet)
            ->where('Trajets.dateHeureArrivee', '>', NOW())
            ->orderBy('Reservations.estAccepte', 'DESC')
            ->get(['Reservations.idTrajet as idTrajet', 'Reservations.idPassager','Reservations.estAccepte', 
                    'Reservations.estPaye', 'Reservations.idReservation','Reservations.nbPlace',
                    'Utilisateurs.prenomUtilisateur', 'Utilisateurs.nomUtilisateur', 'Utilisateurs.photoProfil'])
            ->toArray();
        return $passagers;
    }
    //nombre de places max d'un trajet
    function nbrPlacesMax(int $idTrajet): int
    {
        $nbrplacesMax =  DB::table('Trajets')->where('idTrajet',$idTrajet)->get(['nbPlace'])->toArray()[0];
        return $nbrplacesMax->nbPlace;
    }
    //nombre de passagers acceptées pour un trajet
    function nbrPassagerAcceptes(int $idTrajet): int
    {
        return DB::table('Trajets')
                        ->join('Reservations', 'Trajets.idTrajet', '=', 'Reservations.idTrajet')
                        ->where('Trajets.idTrajet',$idTrajet)
                        ->where('Reservations.estAccepte', '=', 1)
                        ->sum('Reservations.nbPlace');
        
    }
    //méthode pour avertir le passager par message (mail ou chat) d'acceptation et de paiement
    function AvertirAcceptationPassager(int $idEmetteur, int $idDestinataire): int 
    {
        return DB::table('Messages')->insertGetId(['objet' => 'Etat de votre réservation',
                                            'dateMessage' => NOW(),
                                            'texteMessage' => 'Votre réservation a été acceptée avec succès par le chauffeur. Maintenant, vous devez payer le coût du trajet pour compléter votre réservation.',
                                            'idEmetteur' => $idEmetteur,
                                            'idDestinataire' => $idDestinataire]);
    }
    function AvertirRejetPassager(int $idEmetteur, int $idDestinataire): int 
    {
        return DB::table('Messages')->insertGetId(['objet' => 'Etat de votre réservation',
                                            'dateMessage' => NOW(),
                                            'texteMessage' => 'Nous avons le regret de vous informer que le conducteur a refusé votre réservation',
                                            'idEmetteur' => $idEmetteur,
                                            'idDestinataire' => $idDestinataire]);
    }

/*-----------------------------Méthodes pour la page mes reservation en cours--------------------------*/

    // les reservation en cours de passager
    function reservationsEnCours(int $idPassager): array
    {    
        return DB::table('Reservations')
                ->join('Trajets', 'Trajets.idTrajet', '=', 'Reservations.idTrajet')
                ->join('Lieux as lieuD', 'Trajets.idLieuDepart', '=', 'lieuD.idLieu')
                ->join('Lieux as lieuA', 'Trajets.idLieuArrivee', '=', 'lieuA.idLieu')
                ->where('Reservations.idPassager', $idPassager)
                ->where('Trajets.dateHeureArrivee', '>', NOW())
                ->orderBy('Trajets.dateHeureDepart')
                ->get(['Trajets.*', 'Reservations.*','lieuD.numRue as numRueDep', 'lieuD.adresseRue as rueDep',
                        'lieuD.ville as villeDep', 'lieuD.cP as cpDep', 'lieuA.numRue as numRueArr', 
                        'lieuA.adresseRue as rueArr', 'lieuA.ville as villeArr', 'lieuA.cP as cpArr'])
                ->toArray();
    }
    //conducteur d'une reservation
    function quiConducteur(int $idTrajet): array
    {
        return DB::table('Trajets')
                ->join('Voitures', 'Trajets.immatriculation', '=', 'Voitures.immatriculation')
                ->join('Utilisateurs', 'Voitures.idUtilisateur', '=', 'Utilisateurs.idUtilisateur')
                ->where('Trajets.idTrajet',$idTrajet)
                ->get(['Trajets.idTrajet', 'Utilisateurs.nomUtilisateur as nomCond', 
                        'Utilisateurs.prenomUtilisateur as prenomCond', 'Utilisateurs.photoProfil', 
                        'Utilisateurs.idUtilisateur'])
                ->toArray();
    }

}