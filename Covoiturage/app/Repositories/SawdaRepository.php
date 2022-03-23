<?php

namespace App\Repositories;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use IlluminateSupportCarbon;

class SawdaRepository
{
    //
    function getUserId(string $email, string $password): int
    {
        $users=json_decode(json_encode(DB::table('Utilisateurs')->where('emailUtilisateur', $email)->get()->toArray()), true);
        
        if(empty($users)){
            throw new Exception("Utilisateur inconnu"); 
        }
        $user=$users[0];
        $passwordHash=$user["password_hash"];
        $ok = Hash::check($password, $passwordHash);
        if(!$ok){
            throw new Exception("Utilisateur inconnu"); 
        }
        
        return $user['idUtilisateur'];
    }

    function createDataRechercheTrajetForm(string $dateDep, 
    string $numRueDep, string $adresseRueDep, string $villeDep, int $cpDep, int $nbPlace, 
    string $numRueArr, string $adresseRueArr, string $villeArr, int $cpArr): array 
    {
        return [
            'dateDep' => date('Y-m-d H:i:s',strtotime($dateDep)),
            'numRueDep' => $numRueDep,
            'adresseRueDep' => $adresseRueDep,
            'villeDep' => $villeDep,
            'cpDep' => $cpDep,
            'nbPlace' => $nbPlace,
            'numRueArr' => $numRueArr,
            'adresseRueArr' => $adresseRueArr,
            'villeArr' => $villeArr,
            'cpArr' => $cpArr
        ];
    }

    //Requete permettant de returner les résultats de la recherche de l'utilisateur
    function trajetsProposes(array $tableau): array
    {
        return
        $trajetsProposes=json_decode(json_encode(
            DB::table('Trajets as t')
            ->join('Lieux as lDepart', 'lDepart.idLieu', '=', 't.idLieuDepart')
            ->join('Lieux as lArrivee', 'lArrivee.idLieu', '=', 't.idLieuArrivee')
            ->join('Voitures as v', 'v.immatriculation', '=', 't.immatriculation')
            ->join('Utilisateurs as u', 'u.idUtilisateur', '=', 'v.idUtilisateur')
            ->where('lDepart.cP', $tableau['cpDep'])
            ->where('lArrivee.cP', $tableau['cpArr'])
            ->where('t.dateHeureDepart', '>=', $tableau['dateDep'])
            ->where('t.nbPlace', '>=', $tableau['nbPlace'])
            ->limit(10)
            ->get(['t.*', 'lDepart.numRue as numRueDep', 'lDepart.adresseRue as adresseRueDep',
            'lDepart.ville as villeDep', 'lDepart.cP as cpDep',
            'lArrivee.numRue as numRueArr', 'lArrivee.adresseRue as adresseRueArr',
            'lArrivee.ville as villeArr', 'lArrivee.cP as cpArr',
            'u.prenomUtilisateur as prenom', 'u.nomUtilisateur as nom'])
            ->toArray()
        ), true);
    }

    //Requete permettant d'extraire un trajet à travers son id
    function unTrajet(int $unTrajet): array 
    {
        $unTrajet=json_decode(json_encode(
            DB::table('Trajets as t')
            ->join('Lieux as lDepart', 'lDepart.idLieu', '=', 't.idLieuDepart')
            ->join('Lieux as lArrivee', 'lArrivee.idLieu', '=', 't.idLieuArrivee')
            ->where('t.idTrajet', $unTrajet)
            ->get(['t.*', 'lDepart.idLieu as idLieuDepart', 'lArrivee.idLieu as idLieuArrivee',
            'lDepart.numRue as numRueDep', 'lDepart.adresseRue as adresseRueDep',
            'lDepart.ville as villeDep', 'lDepart.cP as cpDep',
            'lArrivee.numRue as numRueArr', 'lArrivee.adresseRue as adresseRueArr',
            'lArrivee.ville as villeArr', 'lArrivee.cP as cpArr'])
            ->toArray()
        ), true);

        //$unTrajet=json_decode(json_encode($data), true); 
        if(empty($unTrajet)){
        throw new Exception("Trajet inconnu"); 
        }

        //var_dump($unTrajet[0]);
        return $unTrajet[0];
        
    }


    //Requete permettant d'extraire un conducteur d'un trajet à travers son id
    function unProfil(int $unTrajet): array 
    {
        $unProfil=json_decode(json_encode(
            DB::table('Trajets')
            ->join('Voitures as v', 'v.immatriculation', '=', 'Trajets.immatriculation')
            ->join('Utilisateurs as u', 'u.idUtilisateur', '=', 'v.idUtilisateur')
            ->where('Trajets.idTrajet', $unTrajet)
            ->get(['u.idUtilisateur', 'u.prenomUtilisateur as prenom', 'u.nomUtilisateur as nom',
            'v.autoriserAnimal as animal', 'v.autoriserFumer as fumer'])
            ->toArray()
        ), true);

        if(empty($unProfil)){
        throw new Exception("Profil inconnu"); 
        }

        return $unProfil[0];
        
    }

    //Requete permettant d'extraire la note recu par un utilisateur
    function uneNote(int $idUtilisateur): array 
    {
        $uneNote=json_decode(json_encode(
            DB::table('Utilisateurs as u')
            ->join('Notations as n', 'n.idUtilisateur', '=', 'u.idUtilisateur')
            ->groupBy('u.idUtilisateur')
            ->having('u.idUtilisateur', $idUtilisateur)
            ->get([DB::raw('AVG(n.note) as notation')])
            ->toArray()
        ), true);
        return $uneNote[0];
    }

    //Requete permettant d'extraire des passagers d'un trajet à travers son id
    function passagers(int $unTrajet): array 
    {
        return
        $passagers=json_decode(json_encode(
            DB::table('Reservations as r')
            ->join('Utilisateurs as u', 'u.idUtilisateur', '=', 'r.idPassager')
            ->where('r.idTrajet', $unTrajet)
            ->get(['u.prenomUtilisateur as prenom', 'u.nomUtilisateur as nom'])
            ->toArray()
        ), true);
    }

    //Requete permettant d'extraire les trajets les moins chers du jour
    function bestTrajets(): array 
    {
        $dateToday = date('Y-m-d H:i:s', time());
        return
        json_decode(json_encode(
            DB::table('Trajets as t')
            ->join('Lieux as lDepart', 'lDepart.idLieu', '=', 't.idLieuDepart')
            ->join('Lieux as lArrivee', 'lArrivee.idLieu', '=', 't.idLieuArrivee')
            ->join('Voitures as v', 'v.immatriculation', '=', 't.immatriculation')
            ->join('Utilisateurs as u', 'u.idUtilisateur', '=', 'v.idUtilisateur')
            ->where('t.dateHeureDepart', '>=', $dateToday)
            ->orderBy('t.prixTrajet')
            ->get(['t.*', 'lDepart.numRue as numRueDep', 'lDepart.adresseRue as adresseRueDep',
            'lDepart.ville as villeDep', 'lDepart.cP as cpDep',
            'lArrivee.numRue as numRueArr', 'lArrivee.adresseRue as adresseRueArr',
            'lArrivee.ville as villeArr', 'lArrivee.cP as cpArr',
            'u.prenomUtilisateur as prenom', 'u.nomUtilisateur as nom'])
            ->toArray()
        ), true);
    }

    //Requete permettant d'extraire la liste des messages d'un utilisateur à travers son id
    function messagesProfil(int $idProfil): array 
    {
        return
        json_decode(json_encode(
            DB::table('Messages as m')
            ->join('Utilisateurs as e', 'm.idEmetteur', '=', 'e.idUtilisateur')
            ->join('Utilisateurs as d', 'm.idDestinataire', '=', 'd.idUtilisateur')
            ->where('m.idEmetteur', $idProfil)
            ->orWhere('m.idDestinataire', $idProfil)
            ->orderBy('m.dateMessage', 'desc')
            ->get(['m.*', 'e.prenomUtilisateur as prenomEmetteur', 'e.nomUtilisateur as nomEmetteur',
            'd.prenomUtilisateur as prenomDestinataire', 'd.nomUtilisateur as nomDestinataire'])
            ->toArray()
        ), true);
    }

    //Requete permettant d'extraire la liste des messages d'un utilisateur avec un autre sur un objet précis
    function unMessages(int $idMsg): array 
    {
        $leMsg=json_decode(json_encode(
            DB::table('Messages as m')
            ->where('m.idMessage', $idMsg)
            ->get()
            ->toArray()
        ), true);

        $idEmetteur=$leMsg[0]['idEmetteur'];
        $idDestinataire=$leMsg[0]['idDestinataire'];
        $objet=$leMsg[0]['objet'];

        return
        json_decode(json_encode(
            DB::table('Messages as m')
            ->join('Utilisateurs as e', 'm.idEmetteur', '=', 'e.idUtilisateur')
            ->join('Utilisateurs as d', 'm.idDestinataire', '=', 'd.idUtilisateur')
            ->whereIn('m.idEmetteur', [$idEmetteur,$idDestinataire])
            ->whereIn('m.idEmetteur', [$idEmetteur,$idDestinataire])
            ->where('m.objet',$objet)
            ->orderBy('m.dateMessage')
            ->get(['m.*', 'e.prenomUtilisateur as prenomEmetteur', 'e.nomUtilisateur as nomEmetteur',
            'd.prenomUtilisateur as prenomDestinataire', 'd.nomUtilisateur as nomDestinataire'])
            ->toArray()
        ), true);
    }

    //Requete permettant d'extraire les trajets et réservations à partir d'un id profil
    function trajetsReservationsProfil(int $idProfil): array 
    {
        $trajetsProfil=json_decode(json_encode(
            DB::table('Utilisateurs as u')
            ->join('Voitures as v', 'v.idUtilisateur', '=', 'u.idUtilisateur')
            ->join('Trajets as t', 't.immatriculation', '=', 'v.immatriculation')
            ->where('u.idUtilisateur', $idProfil)
            ->get(['t.idTrajet as id'])
            ->toArray()
        ), true);

        $reservationsProfil=json_decode(json_encode(
            DB::table('Reservations as r')
            ->where('r.idPassager', $idProfil)
            ->get(['r.idTrajet as id'])
            ->toArray()
        ), true);

        $trajetsReservationsProfil=json_decode(json_encode(
            DB::table('Reservations as r')
            ->join('Utilisateurs as u', 'r.idPassager', '=', 'u.idUtilisateur')
            ->whereIn('r.idTrajet', $trajetsProfil)
            ->orWhereIn('r.idTrajet', $reservationsProfil)
            ->distinct('u.idUtilisateur')
            ->get(['u.idUtilisateur','u.prenomUtilisateur as prenom', 'u.nomUtilisateur as nom'])
            ->toArray()
        ), true);

        $trajetsReservationsProfil2=json_decode(json_encode(
            DB::table('Utilisateurs as u')
            ->join('Voitures as v', 'v.idUtilisateur', '=', 'u.idUtilisateur')
            ->join('Trajets as t', 't.immatriculation', '=', 'v.immatriculation')
            ->orWhereIn('t.idTrajet', $reservationsProfil)
            ->distinct('u.idUtilisateur')
            ->get(['u.idUtilisateur','u.prenomUtilisateur as prenom', 'u.nomUtilisateur as nom'])
            ->toArray()
        ), true);
        
        $trajetsReservationsProfil[]=$trajetsReservationsProfil2[0];

        return $trajetsReservationsProfil;
    }

    /*ajouter un message et retourner son identifiant */
    function insertMsg(array $msg): int
    {   
        return array_key_exists("idMessage", $msg) ? 
        DB::table('Messages')
            ->insertGetId([ 'idMessage' =>$msg['idMessage'],
                            'objet' =>$msg['objet'],
                            'texteMessage' =>$msg['texteMessage'],
                            'dateMessage' =>date('Y-m-d H:i:s', time()),
                            'messageLu' =>'1',
                            'idEmetteur' =>$msg['idEmetteur'],
                            'idDestinataire' =>$msg['idDestinataire'],
                        ])
        : DB::table('Messages')
        ->insertGetId([ 'objet' =>$msg['objet'],
                        'texteMessage' =>$msg['texteMessage'],
                        'dateMessage' =>date('Y-m-d H:i:s', time()),
                        'messageLu' =>'1',
                        'idEmetteur' =>$msg['idEmetteur'],
                        'idDestinataire' =>$msg['idDestinataire'],
                    ])
        ;
    }

    function deleteMsg(int $msgId) : void{
        $msg=json_decode(json_encode(
        DB::table('Messages')
        ->where('idMessage', '=', $msgId)
        ->get()->toArray()
        ), true);
        
        if(empty($msg)){
            throw new Exception("Match inconnu"); 
        }

        $msg=$msg[0];
        DB::table('Messages')
        ->where('idMessage', '=', $msg['idMessage'])
        ->delete();
    }

    /*
     idReservation auto
dateHeureRDV
estPaye 0
estAccepte 0
idAnnule NULL
prixResa
idLieuRencontre
idLieuDepot
idPassager
idTrajet
nbPlace
     */

    function insertReservation(array $reservation): int
    {   
        return array_key_exists("idReservation", $reservation) ? 
        DB::table('Reservations')
            ->insertGetId([ 'idReservation' =>$reservation['idReservation'],
                            'dateHeureRDV' =>date('Y-m-d H:i:s',strtotime($reservation['dateHeureRDV'])),
                            'prixResa' =>$reservation['prixResa'],
                            'idLieuRencontre' =>$reservation['idLieuRencontre'],
                            'idLieuDepot' =>$reservation['idLieuDepot'],
                            'idPassager' =>$reservation['idPassager'],
                            'idTrajet' =>$reservation['idTrajet'],
                            'nbPlace' =>$reservation['nbPlace'],
                            'estPaye' =>'0',
                            'estAccepte' =>'0',
                            'idAnnule' =>'0',
                        ])
        : DB::table('Reservations')
        ->insertGetId([ 'dateHeureRDV' =>date('Y-m-d H:i:s',strtotime($reservation['dateHeureRDV'])),
                        'prixResa' =>$reservation['prixResa'],
                        'idLieuRencontre' =>$reservation['idLieuRencontre'],
                        'idLieuDepot' =>$reservation['idLieuDepot'],
                        'idPassager' =>$reservation['idPassager'],
                        'idTrajet' =>$reservation['idTrajet'],
                        'nbPlace' =>$reservation['nbPlace'],
                        'estPaye' =>'0',
                        'estAccepte' =>'0',
                        'idAnnule' =>'0',
                    ])
        ;
    }
}