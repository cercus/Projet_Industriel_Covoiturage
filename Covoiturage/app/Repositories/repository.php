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
            ->get(['t.*', 'lDepart.numRue as numRueDep', 'lDepart.adresseRue as adresseRueDep',
            'lDepart.ville as villeDep', 'lDepart.cP as cpDep',
            'lArrivee.numRue as numRueArr', 'lArrivee.adresseRue as adresseRueArr',
            'lArrivee.ville as villeArr', 'lArrivee.cP as cpArr',
            'u.prenomUtilisateur as prenom', 'u.nomUtilisateur as nom','u.idUtilisateur as idUtilisateur'])
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
            ->get(['t.*', 'lDepart.numRue as numRueDep', 'lDepart.adresseRue as adresseRueDep',
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
        return json_decode(json_encode(
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
            ->limit(10)
            ->get(['t.*', 'lDepart.numRue as numRueDep', 'lDepart.adresseRue as adresseRueDep',
            'lDepart.ville as villeDep', 'lDepart.cP as cpDep',
            'lArrivee.numRue as numRueArr', 'lArrivee.adresseRue as adresseRueArr',
            'lArrivee.ville as villeArr', 'lArrivee.cP as cpArr',
            'u.prenomUtilisateur as prenom', 'u.nomUtilisateur as nom'])
            ->toArray()
        ), true);
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

        return ['email'=> $user->emailUtilisateur, 'id'=> $user->idUtilisateur, 'prenom'=>$user->prenomUtilisateur, 'nom'=>$user->nomUtilisateur];
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

    function userVoiture($idUtilisateur) : bool {
        $res = DB::table('Voitures')->where('Voitures.idUtilisateur', $idUtilisateur)->get()->toArray();
        return count($res) != 0;
    }
    function getVoitureConducteurFromIdUtilisateur(int $idUtilisateur): array
    {
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

    //    $tableauUser = $this->getUserById($idUtilisateur);
    //    dd($tableauUser);
        // $res = DB::table("Utilisateurs as U1")
        //         ->join("Notations as N", "U1.idUtilisateur","=","N.idUtilisateur")
        //         ->join("Reservations as R","N.idReservation", "=", "R.idReservation")
        //         ->join("Trajets as T","R.idTrajet", "=", "T.idTrajet")
        //         ->join("Utilisateurs as U3","R.idPassager", "=", "U3.idUtilisateur")
        //         ->join("Voitures as V","T.immatriculation", "=", "V.immatriculation")
        //         ->join("Utilisateurs as U2","V.idUtilisateur", "=", "U2.idUtilisateur")
        //         // ->join($idUtilisateur, "idUtilisateur","idUtilisateur")
        //         ->orwhere("U3.idUtilisateur","=",$idUtilisateur)
        //         ->where("U1.idUtilisateur","!=",$idUtilisateur)
        //         ->orwhere("U2.idUtilisateur","=",$idUtilisateur)
        //         ->where("U1.idUtilisateur","!=",$idUtilisateur)
        //         // ->when($idUtilisateur, function($query, $idUtilisateur){
        //         //     if($idUtilisateur == 'U3.idUtilisateur')
        //         //           return $query->where('U2.idUtilisateur');
        //         //     else
        //         //         return $query->where('U2.idUtilisateur');})

        //         // ->when($idUtilisateur, function($query, $idUtilisateur){
        //         //     $query->where($idUtilisateur, "=", 'U2.idUtilisateur');})
        //         // ->when($idUtilisateur, function($query, $idUtilisateur){
        //         //     $query->where($idUtilisateur, "=", 'U3.idUtilisateur');})

        //         ->get(["U1.idUtilisateur as idNoteur","U1.prenomUtilisateur as prenomNoteur",
        //             "U1.nomUtilisateur as nomNoteur", "U2.idUtilisateur as idConducteur",
        //             "U2.prenomUtilisateur as prenomConducteur","U2.nomUtilisateur as nomConducteur",
        //             "U3.idUtilisateur as idPassager","U3.prenomUtilisateur as prenomPassager",
        //             "U3.nomUtilisateur as nomPassager", "N.note as note", "N.texteMessage as texteMessage",
        //             "N.dateNotation as dateNotation", "IF(U1.idUtilisateur=U2.idUtilisateur,U2.idUtilisateur,U3.idUtilisateur) as idNoter"])
        //         ->toArray();

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