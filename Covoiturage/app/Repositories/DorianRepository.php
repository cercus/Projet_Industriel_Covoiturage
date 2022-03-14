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
        $idDepart = DB::table('Lieux')->insertGetId($lieuxDepart);
        $lieuxArrive = [
            "numRue" => $trajet['numRueArr'],
            "adresseRue" => $trajet["rueArr"],
            "ville" => $trajet["villeArr"],
            "cP" => $trajet["cpArr"],
            "pointGPS" =>  DB::raw('POINT('.$trajet['finLon'].','.$trajet['finLat'].')') 
        ];

        $idArrive = DB::table('Lieux')->insertGetId($lieuxArrive);
        $trajetTab = [
            "dateHeureDepart" => $trajet['dateDepart'],
            "nbPlace" => $trajet['place'],
            "dateHeureArrivee" => $this->addSecondes($trajet['dateDepart'], $trajet['tempsTrajet']),
            "prixTrajet" => $trajet['prix'],
            "rayon" => 200,
            "idLieuDepart" => $idDepart,
            "idLieuArrivee" => $idArrive,
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

    function getCaracteristiquesVoiture($idUtilisateur) {
        $res = DB::table("Voitures")->where("idUtilisateur", $idUtilisateur)->get()->toArray();
        if(count($res) != 0) {
            return [
                "immatriculation" => $res[0]->immatriculation,
                "marqueModelVoiture" => $res[0]->marqueModelVoiture,
                "photoVoiture" => $res[0]->photoVoiture,
                "nbPlaceMax" => $res[0]->nbPlaceMax,
                "couleurVoiture" => $res[0]->couleurVoiture,
                "autoriserAnimal" => $res[0]->autoriserAnimal,
                "autoriserFumer" => $res[0]->autoriserFumer,
            ];
        } else {
            return null;
        }
    }


    function getTrajetWithIdTrajetAndIdReservationPassager($idUtilisateur, $idTrajet, $idReservation) {
        $trajets = $this->getAllTrajetsPassager($idUtilisateur);
        if(count($trajets) != 0) {
            foreach ($trajets as $trajet) {
                if($trajet['idTrajet'] == $idTrajet && $trajet['idReservation'] == $idReservation)
                    return $trajet;
            }
        } else {
            return [];
        }
    }

    function getTrajetWithIdTrajetAndIdReservationConducteur($idUtilisateur, $idTrajet, $idReservation) {
        $trajets = $this->getAllTrajetsConducteur($idUtilisateur);
        if(count($trajets) != 0) {
            foreach ($trajets as $trajet) {
                if($trajet['idTrajet'] == $idTrajet && $trajet['idReservation'] == $idReservation)
                    return $trajet;
            }
        } else {
            return [];
        }
    }

    function insertNotation($note, $message, $idReservation, $idUtilisateur) {
        return DB::table("Notations")->insertGetId(["note" => $note, "texteMessage" => $message, "dateNotation" => date(DATE_ATOM, time()), "idReservation" => $idReservation, "idUtilisateur" => $idUtilisateur]);
    }


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


}