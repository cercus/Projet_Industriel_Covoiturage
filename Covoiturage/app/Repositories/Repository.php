<?php

namespace App\Repositories;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Repository {

    /**
     * Fonction pour insérer un trajet
     */
    function insertTrajet(array $trajet, $idUtilisateur) {
        $lieuxDepart = [
            "numRue" => $trajet['numRueDep'],
            "adresseRue" => $trajet["rueDep"],
            "ville" => $trajet["villeDep"],
            "cP" => $trajet["cpDep"],
            "pointGPS" =>  DB::raw('POINT('.$trajet['debutLon'].','.$trajet['debutLat'].')')
        ];
        $idLieuDepart = $this->lieuDejaEntree($trajet['numRueDep'], $trajet["rueDep"], $trajet["cpDep"], $trajet["villeDep"]);
        if($idLieuDepart < 0)
            $idDepart = DB::table('Lieux')->insertGetId($lieuxDepart);
        else
            $idDepart = $idLieuDepart;
        
        $lieuxArrive = [
            "numRue" => $trajet['numRueArr'],
            "adresseRue" => $trajet["rueArr"],
            "ville" => $trajet["villeArr"],
            "cP" => $trajet["cpArr"],
            "pointGPS" =>  DB::raw('POINT('.$trajet['finLon'].','.$trajet['finLat'].')') 
        ];

        $idLieuArrivee = $this->lieuDejaEntree($trajet['numRueArr'], $trajet["rueArr"], $trajet["cpArr"], $trajet["villeArr"]);
        if($idLieuArrivee < 0)
            $idArrive = DB::table('Lieux')->insertGetId($lieuxArrive);
        else
            $idArrive = $idLieuArrivee;

        $trajetTab = [
            "dateHeureDepart" => $trajet['dateDepart'],
            "nbPlace" => $trajet['place'],
            "dateHeureArrivee" => $this->addSecondes($trajet['dateDepart'], $trajet['tempsTrajet']),
            "prixTrajet" => $trajet['prix'],
            "rayon" => 200,
            "idLieuDepart" => $idDepart,
            "idLieuArrivee" => $idArrive,
            "immatriculation" => $this->getImmatriculationOfUser($idUtilisateur)
            //"distance" => $trajet["distance"],
            //"trajetPoints" => $trajet['polyline']
        ];
        return DB::table('Trajets')->insertGetId($trajetTab);
    }

    /**
     * Fonction qui retourne l'id du lieu s'il existe (a partir de l'adresse) ou -4 si il existe pas
     */
    public function lieuDejaEntree($numRue, $adresseRue, $cp, $ville) : int {
        $res = DB::table('Lieux')->where('numRue', $numRue)
                    ->where('adresseRue', $adresseRue)
                    ->where('cp', $cp)
                    ->where('ville', $ville)
                    ->get()->toArray();

        if(count($res) == 0) #Si lieu existe pas
            return -4;
        else
            return $res[0]->idLieu;

    }

    /**
     * Fonction pour obtenir la plaque d'immatriculation d'un user
     */
    function getImmatriculationOfUser(int $idUtilisateur) {
        $res = DB::table("Voitures")->join("Utilisateurs", "Voitures.idUtilisateur", "=", "Utilisateurs.idUtilisateur")->where("Utilisateurs.idUtilisateur", "=", $idUtilisateur)->distinct()->get('Voitures.immatriculation')->toArray();
        //$immatriculation = json_decode(json_encode($res), true); // Convertion de stdClass en Array
        if(empty($res)) {
            throw new Exception("Utilisateur inconnu.");
        }
        return $res[0]->immatriculation;
    }

    /**
     * Fonction pour ajouter des secondes à une date
     */
    function addSecondes($date, $secondes) {
        $sec = strtotime($date)+$secondes;
        return date('Y-m-d H:i:s', $sec);
    }

    /* Fonction pour obtenir tout les trajets d'un utilisateur */
    function getAllTrajetsConducteur($idUtilisateur) {

        $res = DB::table('Trajets as T')
                        ->join("Voitures as V", "T.immatriculation", "=", "V.immatriculation")
                        ->join("Utilisateurs as U", "U.idUtilisateur", "=", "V.idUtilisateur")
                        ->join("Reservations as R", "R.idTrajet", "=", "T.idTrajet")
                        ->join("Lieux as Ld", "Ld.idLieu", "=", "T.idLieuDepart")
                        ->join("Lieux as La", "La.idLieu", "=", "T.idLieuArrivee")
                        ->Join("Utilisateurs as U1", "U1.idUtilisateur", "=", "R.idPassager")
                        ->where("U.idUtilisateur", $idUtilisateur)
                        ->get(["T.dateHeureDepart", "Ld.numRue as numRueDepart", "Ld.adresseRue as rueDepart", "Ld.cP as cpDepart",
                                "Ld.ville as villeDepart", "T.dateHeureArrivee", "La.numRue as numRueArrivee", "La.adresseRue as rueArrivee",
                                "La.cP as cpArrivee", "La.ville as villeArrivee", "R.nbPlace", "R.prixResa",
                                "U.prenomUtilisateur as prenomConducteur", "U.nomUtilisateur as nomConducteur", 
                                "U1.prenomUtilisateur as prenomPassager", "U1.nomUtilisateur as nomPassager", "U1.idUtilisateur as idPassager", 
                                "U.idUtilisateur as idConducteur", "R.idReservation"])->toArray();
        if(count($res) == 0) {
            return [];
        } else {
            $tConducteur = [];
            for($i=0; $i<count($res); $i++) {
                $res2 = DB::table("Notations")->where("idReservation", $res[$i]->idReservation)->get()->toArray();
                if(count($res2) == 0) {
                    $tmpTrajet = [
                        "dateHeureDepart" => $res[$i]->dateHeureDepart,
                        "adresseDepart" => $res[$i]->numRueDepart." ".$res[$i]->rueDepart." ".$res[$i]->cpDepart." ".$res[$i]->villeDepart,
                        "dateHeureArrivee" => $res[$i]->dateHeureArrivee,
                        "adresseArrivee" => $res[$i]->numRueArrivee." ".$res[$i]->rueArrivee." ".$res[$i]->cpArrivee." ".$res[$i]->villeArrivee,
                        "nbPlace" => $res[$i]->nbPlace,
                        "prixResa" => $res[$i]->prixResa,
                        "passager" => $res[$i]->prenomPassager." ".$res[$i]->nomPassager,
                        "conducteur" => $res[$i]->prenomConducteur." ".$res[$i]->nomConducteur,
                        "idConducteur" => $res[$i]->idConducteur,
                        "idPassager" => $res[$i]->idPassager,
                        "idReservation" => $res[$i]->idReservation,
                        "note" => -4
                    ]; 
                } else {
                    $tmpTrajet = [
                        "dateHeureDepart" => $res[$i]->dateHeureDepart,
                        "adresseDepart" => $res[$i]->numRueDepart." ".$res[$i]->rueDepart." ".$res[$i]->cpDepart." ".$res[$i]->villeDepart,
                        "dateHeureArrivee" => $res[$i]->dateHeureArrivee,
                        "adresseArrivee" => $res[$i]->numRueArrivee." ".$res[$i]->rueArrivee." ".$res[$i]->cpArrivee." ".$res[$i]->villeArrivee,
                        "nbPlace" => $res[$i]->nbPlace,
                        "prixResa" => $res[$i]->prixResa,
                        "passager" => $res[$i]->prenomPassager." ".$res[$i]->nomPassager,
                        "conducteur" => $res[$i]->prenomConducteur." ".$res[$i]->nomConducteur,
                        "idConducteur" => $res[$i]->idConducteur,
                        "idPassager" => $res[$i]->idPassager,
                        "idReservation" => $res[$i]->idReservation,
                        "note" => $res2[0]->note
                    ];
                }
                
                array_push($tConducteur, $tmpTrajet);
            }
            return $tConducteur;

        }
        
        
    }

    /* FOnction pour obtenir toutes les reservations d'un utilisateur */
    function getAllTrajetsPassager($idUtilisateur) {

        /* Liste de tout les reservations d'un utilisateur */
        $res = DB::table("Reservations as R")
                        ->join("Utilisateurs as U", "R.idPassager", "=", "U.idUtilisateur")
                        ->join("Trajets as T", "T.idTrajet", "=", "R.idTrajet")
                        ->join("Voitures as V", "V.immatriculation", "=", "T.immatriculation")
                        ->join("Utilisateurs as U1", "V.idUtilisateur", "=", "U1.idUtilisateur")
                        ->join("Lieux as Ld", "Ld.idLieu", "=", "R.idLieuRencontre")
                        ->join("Lieux as La", "La.idLieu", "=", "R.idLieuDepot")
                        ->where("R.idPassager", $idUtilisateur)
                        ->get(["R.dateHeureRDV", "Ld.numRue as numRueDepart", "Ld.adresseRue as rueDepart", "Ld.cP as cpDepart", 
                        "Ld.ville as villeDepart", "T.dateHeureArrivee", "La.numRue as numRueArrivee", "La.adresseRue as rueArrivee", 
                        "La.cP as cpArrivee", "La.ville as villeArrivee", "R.nbPlace", "R.prixResa", "U.prenomUtilisateur as prenomPassager", 
                        "U.nomUtilisateur as nomPassager", "U1.prenomUtilisateur as prenomConducteur", "U1.nomUtilisateur as nomConducteur", 
                        "U1.idUtilisateur as idConducteur", "U.idUtilisateur as idPassager", "R.idReservation"])->toArray();
        if(count($res) == 0) {
            return [];
        } else {
            $tPassager = [];
            for($i=0; $i<count($res); $i++) {
                $res2 = DB::table("Notations")->where("idReservation", $res[$i]->idReservation)->get()->toArray();
                if(count($res2) == 0) {
                    $tmpTrajet = [
                        "dateHeureRDV" => $res[$i]->dateHeureRDV,
                        "adresseDepart" => $res[$i]->numRueDepart." ".$res[$i]->rueDepart." ".$res[$i]->cpDepart." ".$res[$i]->villeDepart,
                        "dateHeureArrivee" => $res[$i]->dateHeureArrivee,
                        "adresseArrivee" => $res[$i]->numRueArrivee." ".$res[$i]->rueArrivee." ".$res[$i]->cpArrivee." ".$res[$i]->villeArrivee,
                        "nbPlace" => $res[$i]->nbPlace,
                        "prixResa" => $res[$i]->prixResa,
                        "passager" => $res[$i]->prenomPassager." ".$res[$i]->nomPassager,
                        "conducteur" => $res[$i]->prenomConducteur." ".$res[$i]->nomConducteur,
                        "idConducteur" => $res[$i]->idConducteur,
                        "idPassager" => $res[$i]->idPassager,
                        "idReservation" => $res[$i]->idReservation,
                        "note" => -4
                    ]; 
                } else {
                    $tmpTrajet = [
                        "dateHeureRDV" => $res[$i]->dateHeureRDV,
                        "adresseDepart" => $res[$i]->numRueDepart." ".$res[$i]->rueDepart." ".$res[$i]->cpDepart." ".$res[$i]->villeDepart,
                        "dateHeureArrivee" => $res[$i]->dateHeureArrivee,
                        "adresseArrivee" => $res[$i]->numRueArrivee." ".$res[$i]->rueArrivee." ".$res[$i]->cpArrivee." ".$res[$i]->villeArrivee,
                        "nbPlace" => $res[$i]->nbPlace,
                        "prixResa" => $res[$i]->prixResa,
                        "passager" => $res[$i]->prenomPassager." ".$res[$i]->nomPassager,
                        "conducteur" => $res[$i]->prenomConducteur." ".$res[$i]->nomConducteur,
                        "idConducteur" => $res[$i]->idConducteur,
                        "idPassager" => $res[$i]->idPassager,
                        "idReservation" => $res[$i]->idReservation,
                        "note" => $res2[0]->note
                    ];
                }
                
                array_push($tPassager, $tmpTrajet);
            }
            return $tPassager;
        }
    }

    /**
     * Fonction pour obtenir un trajet depuis un idReservation
     */
    public function getTrajetFromIdReservation($idReservation) {
        $res = DB::table("Reservations as R")
                    ->join("Lieux as Ld", "R.idLieuRencontre", "=", "Ld.idLieu")
                    ->join("Lieux as La", "R.idLieuDepot", "=", "La.idLieu")
                    ->join("Trajets as T", "T.idTrajet", "=", "R.idTrajet")
                    ->join("Utilisateurs as U", "U.idUtilisateur", "=", "R.idPassager")
                    ->join("Voitures as V", "V.immatriculation", "=", "T.immatriculation")
                    ->Join("Utilisateurs as U1", "U1.idUtilisateur", "=", "V.idUtilisateur")
                    ->where("R.idReservation", $idReservation)
                    ->get(["R.dateHeureRDV", "Ld.numRue as numRueDepart", "Ld.adresseRue as rueDepart", "Ld.cP as cpDepart", 
                            "Ld.ville as villeDepart", "T.dateHeureArrivee", "La.numRue as numRueArrivee", "La.adresseRue as rueArrivee", 
                            "La.cP as cpArrivee", "La.ville as villeArrivee", "R.nbPlace", "R.prixResa", "U.prenomUtilisateur as prenomPassager", 
                            "U.nomUtilisateur as nomPassager", "U1.prenomUtilisateur as prenomConducteur", "U1.nomUtilisateur as nomConducteur", 
                            "U1.idUtilisateur as idConducteur", "U.idUtilisateur as idPassager", "R.idReservation"])
                    ->toArray();
        
        if(count($res) == 0) {
            return [];
        } else {
            $trajet = [
                

            ];
            return $this->stdToArray($res)[0];
        }
    }

    /* Fonction pour convertir un stdClass en Array */
    function stdToArray($array) : array {
        return json_decode(json_encode($array), true);
    }

    /**
     * Fonction pour insérer une note
     */
    function insertNotation($note, $message, $idReservation, $idUtilisateur) {
        return DB::table("Notations")->insertGetId(["note" => $note, "texteMessage" => $message, "dateNotation" => date(DATE_ATOM, time()), "idReservation" => $idReservation, "idUtilisateur" => $idUtilisateur]);
    }

    //Requete permettant d'extraire les trajets les moins chers du jour
    function bestTrajets(): array 
    {
        //$dateToday = "2022-02-21 07:00:00";
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
            ->orderBy('t.dateHeureDepart')
            ->limit(10)
            ->get(['t.*', 'lDepart.numRue as numRueDep', 'lDepart.adresseRue as adresseRueDep',
            'lDepart.ville as villeDep', 'lDepart.cP as cpDep',
            'lArrivee.numRue as numRueArr', 'lArrivee.adresseRue as adresseRueArr',
            'lArrivee.ville as villeArr', 'lArrivee.cP as cpArr',
            'u.prenomUtilisateur as prenom', 'u.nomUtilisateur as nom', 'u.idUtilisateur as idUtilisateur'])
            ->toArray()
        ), true);
    }

    //Requete permettant d'extraire des passagers d'un trajet à travers son id
    function passagers(int $unTrajet): array 
    {
        return json_decode(json_encode(
            DB::table('Reservations as r')
            ->join('Utilisateurs as u', 'u.idUtilisateur', '=', 'r.idPassager')
            ->where('r.idTrajet', $unTrajet)
            ->get(['u.prenomUtilisateur as prenom', 'u.nomUtilisateur as nom'])
            ->toArray()
        ), true);
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

    //Requete permettant d'extraire un trajet à travers son id
    function unTrajet(int $unTrajet): array 
    {
        $unTrajet=json_decode(json_encode(
            DB::table('Trajets as t')
            ->join('Lieux as lDepart', 'lDepart.idLieu', '=', 't.idLieuDepart')
            ->join('Lieux as lArrivee', 'lArrivee.idLieu', '=', 't.idLieuArrivee')
            ->where('t.idTrajet', $unTrajet)
            ->get(['t.*', 'lDepart.idLieu as idLieuDepart', 'lArrivee.idLieu as idLieuArrivee', 'lDepart.numRue as numRueDep', 'lDepart.adresseRue as adresseRueDep',
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

    //Requete permettant de returner les résultats de la recherche de l'utilisateur
    function trajetsProposes(array $tableau): array
    {
        //dd($tableau);
        $res = json_decode(json_encode(
            DB::table('Trajets as t')
            ->join('Lieux as lDepart', 'lDepart.idLieu', '=', 't.idLieuDepart')
            ->join('Lieux as lArrivee', 'lArrivee.idLieu', '=', 't.idLieuArrivee')
            ->join('Voitures as v', 'v.immatriculation', '=', 't.immatriculation')
            ->join('Utilisateurs as u', 'u.idUtilisateur', '=', 'v.idUtilisateur')
            ->where("lDepart.adresseRue", $tableau['adresseRueDep'])
            ->where("lArrivee.adresseRue", $tableau['adresseRueArr'])
            ->where('lDepart.cP', $tableau['cpDep'])
            ->where('lArrivee.cP', $tableau['cpArr'])
            ->where('t.dateHeureDepart', '>=', $tableau['dateDep'])
            ->where('t.nbPlace', '>=', $tableau['nbPlace'])
            ->orderBy('t.dateHeureDepart')
            ->limit(10)
            ->get(['t.*', 'lDepart.numRue as numRueDep', 'lDepart.adresseRue as adresseRueDep',
            'lDepart.ville as villeDep', 'lDepart.cP as cpDep',
            'lArrivee.numRue as numRueArr', 'lArrivee.adresseRue as adresseRueArr',
            'lArrivee.ville as villeArr', 'lArrivee.cP as cpArr',
            'u.prenomUtilisateur as prenom', 'u.nomUtilisateur as nom'])
            ->toArray()
        ), true);
        //dd($res);
        return $res;
    }

    function createDataRechercheTrajetForm(string $dateDep, string $numRueDep, string $adresseRueDep, string $villeDep, int $cpDep, int $nbPlace, string $numRueArr, string $adresseRueArr, string $villeArr, int $cpArr): array 
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


    /**
     * FOnction pour obtenir mdp, email et id utilisateur
     */
    function getUser(string $email, string $password): array
    {
        $user = DB::table('Utilisateurs')->where('emailUtilisateur', $email)->get()->toArray();

        if (empty($user))  // si l'utilisateur n'existe pas
            throw new Exception("Cet utilisateur n'existe pas."); 

        $user=$user[0];

        if (! Hash::check($password, $user->password)) // si le password n'est pas hashé ou que le paswoord n'est pa bon
            throw new Exception("Ce compte n'existe pas. Vérifier votre mail et votre mot de passe.");
  
        return ['email'=> $user->emailUtilisateur, 'id'=> $user->idUtilisateur, 'prenom'=>$user->prenomUtilisateur, 'nom'=>$user->nomUtilisateur, 'photo' =>$user->photoProfil];
    }

    /** FOnction pour ajouter un utilisateur */
    function addUser(array $user): int
    {
        //'emailUtilisateur', 'photoProfil', 'password', 'numTelUtilisateur', 'dateNaiss', 'descriptionUtilisateur', 'numPermisConduire', 'numeroIdentite'
        var_dump($user);
        return DB::table('Utilisateurs')->insertGetId($user);

    }

    // ajouter à la base de données un véhicule
    function addCar(array $voiture): void
    {
        DB::table('Voitures')->insertGetId($voiture);
    }
    // Id dans l'url ?
    function userVoiture($idUtilisateur) : bool {
        $res = DB::table('Voitures')->where('Voitures.idUtilisateur', $idUtilisateur)->get()->toArray();
        return count($res) != 0;
    }

    function messagesProfil(int $idUtilisateur) : array {
        $res = json_decode(json_encode(
            DB::table('Messages as m')
            ->join('Utilisateurs as e', 'm.idEmetteur', '=', 'e.idUtilisateur')
            ->join('Utilisateurs as d', 'm.idDestinataire', '=', 'd.idUtilisateur')
            ->where('m.idEmetteur', $idUtilisateur)
            ->orWhere('m.idDestinataire', $idUtilisateur)
            ->orderBy('m.dateMessage', 'desc')
            ->get(['m.*', 'e.prenomUtilisateur as prenomEmetteur', 'e.nomUtilisateur as nomEmetteur',
            'd.prenomUtilisateur as prenomDestinataire', 'd.nomUtilisateur as nomDestinataire'])
            ->toArray()
        ), true);
        //dd($res);
        return $res;
    }

    function deleteMsg(int $msgId) : void{
        $msg=json_decode(json_encode(
        DB::table('Messages')
        ->where('idMessage', '=', $msgId)
        ->get()->toArray()
        ), true);
        
        if(empty($msg)){
            throw new Exception("Message inconnu."); 
        }

        $msg=$msg[0];
        DB::table('Messages')
        ->where('idMessage', '=', $msg['idMessage'])
        ->delete();
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
        
        if(empty($trajetsReservationsProfil2))
            $trajetsReservationsProfil = [];
        else
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

    function infoPersonnelles($idUtilisateur) {
        $infoPerso =  DB::table('Utilisateurs')
        ->where('idUtilisateur', $idUtilisateur)
        ->get()
        ->toArray();
    if (count($infoPerso) == 0){
        throw new Exception("L'utilisateur inconnu");
    }
        return $infoPerso;
    }

    function nbrTrajetPassager($idUtilisateur) : int {
        $nbrTrajetPassager = DB::table('Utilisateurs')
            ->join('Reservations', 'Utilisateurs.idUtilisateur', '=', 'Reservations.idPassager')
            ->where('Reservations.idPassager', $idUtilisateur)
            ->get()
            ->toArray();
        return count($nbrTrajetPassager);
    }

    function nbrTrajetConducteur(int $idUtilisateur) : int {
        $nbrTrajetConducteur = DB::table('Voitures')
            ->join('Trajets', 'Voitures.immatriculation', '=', 'Trajets.immatriculation')
            ->where('idUtilisateur', $idUtilisateur)
            ->get()
            ->toArray();
        return count($nbrTrajetConducteur);
    }

    function estConducteur(int $idUtilisateur): bool {
        $condcuteurs = DB::table('Utilisateurs')
                ->join('Voitures', 'Utilisateurs.idUtilisateur', '=', 'Voitures.idUtilisateur')
                ->where('Voitures.idUtilisateur', $idUtilisateur)
                ->get('Voitures.*')
                ->toArray();
        return count($condcuteurs) != 0;
    }

    function infoTechniques(int $idUtilisateur) {
        $infoTechnique =  DB::table('Utilisateurs')
                ->join('Voitures', 'Utilisateurs.idUtilisateur', '=', 'Voitures.idUtilisateur')
                ->where('Voitures.idUtilisateur', $idUtilisateur)
                ->get('Voitures.*')
                ->toArray();
        return $infoTechnique;   
    }

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
        //dd($trajetsEnCours);
                            
        // if (count($trajetsEnCours) == 0){
        //     throw new Exception("Vous n'êtes pas conducteur");
        // }
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

    function estMonTrajet(int $idConducteur, int $idTrajet): bool {
        $mesTrajets =  DB::table('Trajets')
                    ->join('Voitures', 'Trajets.immatriculation', '=', 'Voitures.immatriculation')
                    ->join('Utilisateurs', 'Voitures.idUtilisateur', '=', 'Utilisateurs.idUtilisateur')
                    ->where('Trajets.idTrajet', $idTrajet)
                    ->where('Utilisateurs.idUtilisateur', $idConducteur)
                    ->get()
                    ->toArray();
        return count($mesTrajets) != 0;
    }

    function existeReservation(int $idReservation, int $idPassager): bool
    {
        $reservation = DB::table('Reservations')->where('idReservation', $idReservation)
                                                ->where('idPassager', $idPassager)
                                                ->get()
                                                ->toArray();
        return count($reservation) != 0;
    }

    function quiMonConducteur(int $idReservation): array
    {
        return DB::table('Reservations')
                ->join('Trajets', 'Reservations.idTrajet', '=', 'Trajets.idTrajet')
                ->join('Voitures', 'Trajets.immatriculation', '=', 'Voitures.immatriculation')
                ->join('Utilisateurs', 'Voitures.idUtilisateur', '=', 'Utilisateurs.idUtilisateur')
                ->where('Reservations.idReservation',$idReservation)
                ->get(['Utilisateurs.idUtilisateur'])
                ->toArray();
    }

    // les reservation en cours de passager
    function reservationsEnCours(int $idPassager): array {    
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
    function quiConducteur(int $idTrajet): array {
        return DB::table('Trajets')
                ->join('Voitures', 'Trajets.immatriculation', '=', 'Voitures.immatriculation')
                ->join('Utilisateurs', 'Voitures.idUtilisateur', '=', 'Utilisateurs.idUtilisateur')
                ->where('Trajets.idTrajet',$idTrajet)
                ->get(['Trajets.idTrajet', 'Utilisateurs.nomUtilisateur as nomCond', 
                        'Utilisateurs.prenomUtilisateur as prenomCond', 'Utilisateurs.photoProfil', 
                        'Utilisateurs.idUtilisateur'])
                ->toArray();
    }

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

    function getVoitureConducteurFromIdUtilisateur(int $idUtilisateur): array {
        //dd(json_decode(json_encode($idUtilisateur), true));
        $user = DB::table('Utilisateurs AS U')
                ->join("Voitures as V", "U.idUtilisateur","=","V.idUtilisateur")
                ->where('V.idUtilisateur', $idUtilisateur)
                ->get(['immatriculation','marqueModelVoiture','nbPlaceMax','couleurVoiture', 'autoriserAnimal', 'autoriserFumer'])
                ->toArray();
        if (empty($user))  // si l'utilisateur n'existe pas
            throw new Exception("Cet utilisateur n'existe pas ou n'a pas de véhicule.");

       $user=$user[0];
       $user = json_decode(json_encode($user), true);
       //dd(json_decode(json_encode($user), true));
        return $user;
    }
    function getSumNotationGlobalUtilisateur(int $idUtilisateur): array
    {
        //dd(json_decode(json_encode($idUtilisateur), true));
        $sumNoteGlobal = "SELECT
	            Sum(note) AS sumNote
            FROM Utilisateurs AS U2 INNER JOIN (
	            Voitures AS V INNER JOIN (
	            Utilisateurs AS U3 INNER JOIN (
	            Trajets AS T INNER JOIN (
	            (
                Reservations AS R INNER JOIN
                Notations AS N
                ON R.idReservation = N.idReservation)
                INNER JOIN Utilisateurs AS U1
                ON N.IdUtilisateur = U1.idUtilisateur)
                ON T.idTrajet = R.idTrajet)
                ON U3.idUtilisateur = R.idPassager)
                ON V.immatriculation = T.immatriculation)
                ON U2.idUtilisateur = V.idUtilisateur
            WHERE If(U1.idUtilisateur=U2.idUtilisateur,U3.idUtilisateur,U2.idUtilisateur)= :idFiltre;";
       //dd($query);

        $data = ['idFiltre'=>$idUtilisateur];
        $res = DB::select($sumNoteGlobal, $data);
        $res=$res[0];
        //dd($res);
        return json_decode(json_encode($res), true);

    }

     function getNotationGlobalUtilisateur(int $idUtilisateur): int
    {
        $sumNotation=$this->getSumNotationGlobalUtilisateur($idUtilisateur);
        $countNotation=$this->getCountNotationGlobalUtilisateur($idUtilisateur);
        $notationUtilisateur = $sumNotation['sumNote']/$countNotation['countNote'];
        return json_decode(json_encode($notationUtilisateur), true);
    }

    function getCountNotationGlobalUtilisateur(int $idUtilisateur): array
    {
        //dd(json_decode(json_encode($idUtilisateur), true));
        $countNoteGlobal = "SELECT
	            Count(note) AS countNote
            FROM Utilisateurs AS U2 INNER JOIN (
	            Voitures AS V INNER JOIN (
	            Utilisateurs AS U3 INNER JOIN (
	            Trajets AS T INNER JOIN (
	            (
                Reservations AS R INNER JOIN
                Notations AS N
                ON R.idReservation = N.idReservation)
                INNER JOIN Utilisateurs AS U1
                ON N.IdUtilisateur = U1.idUtilisateur)
                ON T.idTrajet = R.idTrajet)
                ON U3.idUtilisateur = R.idPassager)
                ON V.immatriculation = T.immatriculation)
                ON U2.idUtilisateur = V.idUtilisateur
            WHERE If(U1.idUtilisateur=U2.idUtilisateur,U3.idUtilisateur,U2.idUtilisateur)= :idFiltre;";
       //dd($query);

        $data = ['idFiltre'=>$idUtilisateur];
        $res = DB::select($countNoteGlobal, $data);
        $res=$res[0];
        return json_decode(json_encode($res), true);

    }
    /* Fonction pour obtenir les caractéristiques d'un user */
    function getCharacteristicsUsers($idUtilisateur) : array {

        $query= "SELECT U2.idUtilisateur AS idConducteur,
                        U2.prenomUtilisateur AS prenomConducteur,
                        U2.nomUtilisateur AS nomConducteur,
                        U3.idUtilisateur AS idPassager,
                        U3.prenomUtilisateur AS prenomPassager,
                        U3.nomUtilisateur AS nomPassager,
                        U1.idUtilisateur AS idNoteur,
                        U1.prenomUtilisateur AS prenomNoteur,
                        U1.nomUtilisateur AS nomNoteur,
                        R.DateHeureRDV AS DateHeureRDV,
                        R.prixResa AS prixResa,
                        If(U1.idUtilisateur=U2.idUtilisateur,U3.idUtilisateur,U2.idUtilisateur) AS idNote,
                        If(U1.idUtilisateur=U2.idUtilisateur,U3.prenomUtilisateur,U2.prenomUtilisateur) AS prenomNote,
                        If(U1.idUtilisateur=U2.idUtilisateur,U3. nomUtilisateur, U2.nomUtilisateur) AS nomNote,
                        N.note AS note,
                        N.texteMessage AS texteMessage,
                        N.dateNotation AS dateNotation,
                        L1.numRue AS numRueRencontre,
                        L1.adresseRue AS adresseRueRencontre,
                        L1.cP AS cPRencontre,
                        L1.ville AS villeRencontre,
                        L2.numRue AS numRueDepot,
                        L2.adresseRue AS adresseRueDepot,
                        L2.cP AS cPDepot,
                        L2.ville AS villeDepot,
                        V.nbPlaceMax AS nbPlaceMax,
                        V.photoVoiture AS photoVoiture,
                        V.immatriculation AS immatriculation,
                        V.marqueModelVoiture AS marqueModelVoiture
                FROM Lieux AS L1 INNER JOIN(
                        Lieux AS L2 INNER JOIN(
                        Utilisateurs AS U2 INNER JOIN (
                        Voitures AS V INNER JOIN (
                        Utilisateurs AS U3 INNER JOIN (
                        Trajets AS T INNER JOIN (
                        (
                            Reservations  as R INNER JOIN
                            Notations  as N ON R.idReservation = N.idReservation
                        ) INNER JOIN
                        Utilisateurs AS U1
                        ON N.IdUtilisateur = U1.idUtilisateur)
                        ON T.idTrajet = R.idTrajet)
                        ON U3.idUtilisateur = R.idPassager)
                        ON V.immatriculation = T.immatriculation)
                        ON U2.idUtilisateur = V.idUtilisateur)
                        ON L2.idLieu = R.idLieuRencontre)
                        ON L1.idLieu = R.idLieuDepot
                WHERE If(U1.idUtilisateur=U2.idUtilisateur,U3.idUtilisateur,U2.idUtilisateur)= :idFiltre;";
        //dd($query);
        $data = ['idFiltre'=>$idUtilisateur];
        $res = DB::select($query, $data);

        //dd(json_decode(json_encode($res), true));
        return json_decode(json_encode($res), true);
    }

}