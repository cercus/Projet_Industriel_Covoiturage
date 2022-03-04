<?php

namespace App\Repositories;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SawdaRepository
{
    function createDataRechercheTrajetForm($dateDep, 
    $numRueDep, $adresseRueDep, $villeDep, $cpDep, $nbPlace, $numRueArr, $adresseRueArr,
    $villeArr, $cpArr): array 
    {
        return [
            'dateDep' => $dateDep,
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
            ->get(['t.*', 'lDepart.numRue as numRueDep', 'lDepart.adresseRue as adresseRueDep',
            'lDepart.ville as villeDep', 'lDepart.cP as cpDep',
            'lArrivee.numRue as numRueArr', 'lArrivee.adresseRue as adresseRueArr',
            'lArrivee.ville as villeArr', 'lArrivee.cP as cpArr',
            "'t.dateHeureDepart'-'t.dateHeureDepart' as min", 'u.prenomUtilisateur as prenom',
            'u.nomUtilisateur as nom'])
            ->toArray()
        ), true);

        if(empty($trajetsProposes)){
        throw new Exception("Aucun trajet"); 
        }

       // var_dump($trajetsProposes);

        return $trajetsProposes;
    }

    //Requete permettant d'extraire un trajet à travers son id
    function unTrajet(int $unTrajet): array 
    {
        $unTrajet=json_decode(json_encode(
            DB::table('Trajets')
            ->where('Trajets.idTrajet', $unTrajet)
            ->get()
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
    function unProfil(int $UnTrajet): array 
    {
        $UnProfil=json_decode(json_encode(
            DB::table('Trajets')
            ->join('Voitures as v', 'v.immatriculation', '=', 't.immatriculation')
            ->join('Utilisateurs as u', 'u.idUtilisateur', '=', 't.idUtilisateur')
            ->where('Trajets.idTrajet', $UnTrajet)
            ->get(['u.prenomUtilisateur as prenom', 'u.nomUtilisateur as nom'])
            ->toArray()
        ), true);

        if(empty($unProfil)){
        throw new Exception("Profil inconnu"); 
        }

        return $unProfil[0];
        
    }

    //Requete permettant d'extraire des passagers d'un trajet à travers son id
    function passagers(int $unTrajet): array 
    {
        return [
            [
            'id' => 2,'photo' => 'photo',
            'nom' => 'A.', 'prenom' => 'Sawda'
            ],
            [
            'id' => 2,'photo' => 'photo',
            'nom' => 'I.', 'prenom' => 'Ismail'
            ]
        ];
    }

    //Requete permettant d'extraire les trajets les moins chers du jour
    function bestTrajets(): array 
    {
        $dateToday = date('m-d-Y h:i:s', time());
        $bestTrajets=json_decode(json_encode(
            DB::table('Trajets')
            ->where('Trajets.dateHeureDepart', '>=', $dateToday)
            ->orderBy('Trajets.prixTrajet')
            ->get()
            ->toArray()
        ), true);

        if(empty($bestTrajets)){
        throw new Exception("Aucun trajet"); 
        }

        return $bestTrajets;
    }
}