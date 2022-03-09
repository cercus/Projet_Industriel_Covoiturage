<?php

namespace App\Repositories;

use Exception;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\isNull;

class DorianRepository {

    function getImmatriculationOfUser(int $idUtilisateur) : array {
        $res = DB::table("Voitures")->join("Utilisateurs", "Voitures.idUtilisateur", "=", "Utilisateurs.idUtilisateur")->where("Utilisateurs.idUtilisateur", "=", $idUtilisateur)->distinct()->get('Voitures.immatriculation')->toArray();
        $immatriculation = json_decode(json_encode($res), true); // Convertion de stdClass en Array
        if(empty($immatriculation)) {
            throw new Exception("Utilisateur inconnu.");
        }
        return $immatriculation[0];
    }

    function addSecondes($date, $secondes) {
        $sec = strtotime($date)+$secondes;
        return date('Y-m-d H:i:s', $sec);
    }

    function insertTrajet(array $trajet) {
        $lieuxDepart = [
            "numRue" => $trajet['numRueDep'],
            "adresseRue" => $trajet["rueDep"],
            "ville" => $trajet["villeDep"],
            "cP" => $trajet["cpDep"],
            "pointGPS" =>  DB::raw('POINT('.$trajet['debutLon'].','.$trajet['debutLat'].')')
        ];
        $lieuxArrive = [
            "numRue" => $trajet['numRueArr'],
            "adresseRue" => $trajet["rueArr"],
            "ville" => $trajet["villeArr"],
            "cP" => $trajet["cpArr"],
            "pointGPS" =>  DB::raw('POINT('.$trajet['finLon'].','.$trajet['finLat'].')') 
        ];
        $trajetTab = [
            "dateHeureDepart" => $trajet['dateDepart'],
            "nbPlace" => $trajet['place'],
            "dateHeureArrivee" => $this->addSecondes($trajet['dateDepart'], $trajet['tempsTrajet']),
            "prixTrajet" => $trajet['prix'],
            "rayon" => 200,
            "idLieuDepart" => 29, //$idDepart,
            "idLieuArrivee" => 30, //$idArrive,
            "immatriculation" => $this->getImmatriculationOfUser(1)["immatriculation"]
            //"distance" => $trajet["distance"],
            //"trajetPoints" => $trajet['polyline']
        ];
        return DB::table('Trajets')->insertGetId($trajetTab);
    }

    /* Fonction pour obtenir une adresse pour un lieu donné */
    function getAdresseForOneLieu($idLieu) : array {
        $res = DB::table("Lieux")->where("Lieux.idLieu", "=", $idLieu)->get(["Lieux.numRue", "Lieux.adresseRue", "Lieux.ville", "Lieux.cP"])->toArray();
        return json_decode(json_encode($res[0]), true);
    }

    /* Fonction pour convertir un stdClass en Array */
    function stdToArray($array) : array {
        return json_decode(json_encode($array), true);
    }


    /* Fonction pour obtenir tout les trajets d'un utilisateur */
    function getAllTrajetsConducteur($idUtilisateur) {
        $res = DB::table("Trajets as T")
                        ->join("Voitures as V", "V.immatriculation", "=", "T.immatriculation")
                        ->join("Utilisateurs as U", "U.idUtilisateur", "=", "V.idUtilisateur")
                        ->join("Reservations as R", "R.idTrajet", "=", "T.idTrajet")
                        ->join("Utilisateurs as U1", "U1.idUtilisateur", "=", "R.idPassager")
                        ->where("U.idUtilisateur", $idUtilisateur)
                        ->distinct()
                        ->get(["T.dateHeureDepart", "T.dateHeureArrivee", "U.prenomUtilisateur as conducteurPrenom", "U.nomUtilisateur as conducteurNom", "U1.prenomUtilisateur as passagerPrenom", "U1.nomUtilisateur as passagerNom", "T.idLieuDepart", "T.idLieuArrivee", "T.idTrajet", "R.idPassager", "R.idReservation"])
                        ->toArray();
        $listeTrajet = $this->stdToArray($res);
        if(count($listeTrajet) != 0) {
            $listeTrajetConducteur = [];
            for($i = 0;  $i < count($listeTrajet); $i++){
                $idDepart = $this->stdToArray($this->getAdresseForOneLieu($listeTrajet[$i]['idLieuDepart']));
                $idArrive = $this->stdToArray($this->getAdresseForOneLieu($listeTrajet[$i]['idLieuArrivee']));

                $adresseDepart = implode(" ", $idDepart);
                $adresseArrive = implode(" ", $idArrive);
                $split = explode(" ", $listeTrajet[$i]["dateHeureDepart"]);
                $date = $split[0];
                $heureDepart = $split[1];
                $heureArrivee =  explode(" ", $listeTrajet[$i]["dateHeureArrivee"])[1];
                $tmpTraj = [
                    "date" => $date,
                    "conducteur" => $listeTrajet[$i]["conducteurPrenom"]. " ". $listeTrajet[$i]["conducteurNom"],
                    "passager" => $listeTrajet[$i]["passagerPrenom"]. " ". $listeTrajet[$i]["passagerNom"],
                    "adresseDepart" => $adresseDepart,
                    "heureDepart" => $heureDepart,
                    "adresseArrivee" => $adresseArrive,
                    "heureArrivee" => $heureArrivee,
                    "idTrajet" => $listeTrajet[$i]["idTrajet"],
                    "idPassager" => $listeTrajet[$i]['idPassager'],
                    "idReservation" => $listeTrajet[$i]['idReservation'],
                    "notation" => $this->getNotationForOneUser($listeTrajet[$i]['idReservation'], $listeTrajet[$i]["passagerPrenom"], $listeTrajet[$i]["passagerNom"])
                ];
                array_push($listeTrajetConducteur, $tmpTraj);
            }
            return $listeTrajetConducteur;
        } else {
            return [];
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
                        ->where("R.idPassager", $idUtilisateur)
                        ->get(["T.dateHeureDepart", "T.dateHeureArrivee", "U.prenomUtilisateur as passagerPrenom", "U.nomUtilisateur as passagerNom", "U1.prenomUtilisateur as conducteurPrenom", "U1.nomUtilisateur as conducteurNom", "T.idLieuDepart", "T.idLieuArrivee", "T.idTrajet", "R.idPassager", "R.idReservation"])->toArray();
        $listeTrajet = $this->stdToArray($res);
        if(count($listeTrajet) != 0) {

            $listTrajetPassager = [];
            
            // On parcourt tout les trajets du conducteurs qu'on ajoute a une liste
            for($i = 0; $i < count($listeTrajet); $i++) {
                $idDepart = $this->stdToArray($this->getAdresseForOneLieu($listeTrajet[$i]['idLieuDepart']));
                $idArrive = $this->stdToArray($this->getAdresseForOneLieu($listeTrajet[$i]['idLieuArrivee']));
                $adresseDepart = implode(" ", $idDepart);
                $adresseArrive = implode(" ", $idArrive);
                $split = explode(" ", $listeTrajet[$i]["dateHeureDepart"]);
                $date = $split[0];
                $heureDepart = $split[1];
                $heureArrivee =  explode(" ", $listeTrajet[$i]["dateHeureArrivee"])[1];
                $tmpTraj = [
                    "date" => $date,
                    "conducteur" => $listeTrajet[$i]["conducteurPrenom"]. " ". $listeTrajet[$i]["conducteurNom"],
                    "passager" => $listeTrajet[$i]["passagerPrenom"]. " ". $listeTrajet[$i]["passagerNom"],
                    "adresseDepart" => $adresseDepart,
                    "heureDepart" => $heureDepart,
                    "adresseArrivee" => $adresseArrive,
                    "heureArrivee" => $heureArrivee,
                    "idTrajet" => $listeTrajet[$i]["idTrajet"],
                    "idPassager" => $listeTrajet[$i]["idPassager"],
                    "idReservation" => $listeTrajet[$i]['idReservation'],
                    "notation" => $this->getNotationForOneUser($listeTrajet[$i]['idReservation'], $listeTrajet[$i]["conducteurPrenom"], $listeTrajet[$i]["conducteurNom"])
                ];
                array_push($listTrajetPassager, $tmpTraj);
            }
            return $listTrajetPassager;
        } else {
            return [];
        }
    }

    function getNotationForOneUser($idReservation, $prenomUtilisateur, $nomUtilisateur){
        $res = DB::table("Notations as N")
                        ->join("Utilisateurs as U", "U.idUtilisateur", "=", "N.idUtilisateur")
                        ->where("N.idReservation", $idReservation)
                        ->where("U.prenomUtilisateur", $prenomUtilisateur)
                        ->where("U.nomUtilisateur", $nomUtilisateur)
                        ->get()->toArray();
        $note = $this->stdToArray($res);
        if(count($note) == 0) {
            return -4;
        }
        return $note[0]['note'];
                        
    }
}