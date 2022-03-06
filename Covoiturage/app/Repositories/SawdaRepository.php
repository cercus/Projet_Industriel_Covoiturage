<?php

namespace App\Repositories;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use IlluminateSupportCarbon;

class SawdaRepository
{
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
        $dateToday = "2022-02-21 07:00:00";
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
}