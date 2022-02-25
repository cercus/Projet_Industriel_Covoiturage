<?php

namespace App\Repositories;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\Repositories\Data;

class Repository
{
    function createDataRechercheTrajetForm($dateDep, 
    $timeDep, $numRueDep, $adresseRueDep, $villeDep, $cpDep, $nbPlace, $numRueArr, $adresseRueArr,
    $villeArr, $cpArr): array 
    {
        return [
            'dateDep' => $dateDep,
            'timeDep' => $timeDep,
            'numRueDep' => $numRueDep,
            'adresseRueDep' => $adresseRueDep,
            'villeDep' => $villeDep,
            'cpDep' => $cpDep,
            'nbPlace' => $nbPlace,
            'numRueArr' => $numRueArr,
            'adresseRueArr' => $adresseRueArr,
            'villeArr' => $villeArr,
            'cpArr' => $cpArr,
        ];
    }

    //Requete permettant de returner les résultats de la recherche de l'utilisateur

    //Requete permettant d'extraire un trajet à travers son id
    function UnTrajet(int $UnTrajet): array 
    {
        return ['id' => 1, 'jour' => 'Jeu', 'date' => '24/02', 'heure' => '7h30',
        'numRueDep' => 23, 'adresseRueDep' => 'Rue mathieu stilatti',
        'villeDep' => 'Marseille', 'cpDep' => '13003',
        'nbPlace' => 4, 'numRueArr' => 24,
        'adresseRueArr' => 'Rue', 'villeArr' => 'Luminy',
        'cpArr' => 13400, 'prix' => 5, 
        'idConducteur' => 2,'duree' => 30, 'photo' => 'photo',
        'nom' => 'D.', 'prenom' => 'Nicolas'
        ];
    }
    //Requete permettant d'extraire un conducteur d'un trajet à travers son id
    function UnProfil(int $UnTrajet): array 
    {
        return [
        'id' => 2,'photo' => 'photo',
        'nom' => 'D.', 'prenom' => 'Nicolas',
        'notation' => 5, 'commentaire' => 'J\'accepte tout'
        ];
    }
    //Requete permettant d'extraire des passagers d'un trajet à travers son id
    function passagers(int $UnTrajet): array 
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

    //Requete permettant d'extraire les trajets les moins chers
    function bestTrajets(): array 
    {
        return [
            ['id' => 4, 'jour' => 'Jeu', 'date' => '24/02', 'heure' => '7h30',
        'numRueDep' => 23, 'adresseRueDep' => 'Rue mathieu stilatti',
        'villeDep' => 'Marseille', 'cpDep' => '13003',
        'nbPlace' => 4, 'numRueArr' => 24,
        'adresseRueArr' => 'Rue', 'villeArr' => 'Luminy',
        'cpArr' => 13400, 'prix' => 1, 
        'idConducteur' => 2,'duree' => 30, 'photo' => 'photo',
        'nom' => 'D.', 'prenom' => 'Aziz'
        ],
        ['id' => 5, 'jour' => 'Jeu', 'date' => '24/02', 'heure' => '7h30',
        'numRueDep' => 23, 'adresseRueDep' => 'Rue mathieu stilatti',
        'villeDep' => 'Marseille', 'cpDep' => '13003',
        'nbPlace' => 4, 'numRueArr' => 24,
        'adresseRueArr' => 'Rue', 'villeArr' => 'Luminy',
        'cpArr' => 13400, 'prix' => 1, 
        'idConducteur' => 2,'duree' => 70, 'photo' => 'photo',
        'nom' => 'Y.', 'prenom' => 'Djamila'
        ],
        ['id' => 6, 'jour' => 'Jeu', 'date' => '24/02', 'heure' => '7h30',
        'numRueDep' => 23, 'adresseRueDep' => 'Rue mathieu stilatti',
        'villeDep' => 'Marseille', 'cpDep' => '13003',
        'nbPlace' => 4, 'numRueArr' => 24,
        'adresseRueArr' => 'Rue', 'villeArr' => 'Luminy',
        'cpArr' => 13400, 'prix' => 3, 
        'idConducteur' => 2,'duree' => 45, 'photo' => 'photo',
        'nom' => 'O.', 'prenom' => 'Ousmane'
        ],
        ['id' => 7, 'jour' => 'Jeu', 'date' => '24/02', 'heure' => '7h30',
        'numRueDep' => 23, 'adresseRueDep' => 'Rue mathieu stilatti',
        'villeDep' => 'Marseille', 'cpDep' => '13003',
        'nbPlace' => 4, 'numRueArr' => 24,
        'adresseRueArr' => 'Rue', 'villeArr' => 'Luminy',
        'cpArr' => 13400, 'prix' => 3, 
        'idConducteur' => 2,'duree' => 20, 'photo' => 'photo',
        'nom' => 'A.', 'prenom' => 'Zeilata'
        ],
        ];
    }
}