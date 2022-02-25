<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Exception;
use Illuminate\Support\Facades\Cookie;
use App\Repositories\Repository;
use App\Repositories\Data;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(Repository $repository, Data $data)
    {
        $this->repository = $repository;
        $this->data = $data;
    }
    public function showQuestionForm() {
        return view('question');
    }

    public function showInscriptionForm() {
        return view('inscription');
    }

    // FOnction pour afficher la page de connexion
    public function showConnexionForm() {
        return view('connexion');
    }

    /******************** Page qui sommes nous  ********************/
    public function quisommesnous()
    {
        return view('quisommesnous');
    }

    /******************** Page paiement  ********************/
    public function paiement()
    {
        return view('paiement');
    }

    /******************** Page cofirmation d'annulation ********************/
    public function confirmationannulation()
    {
        return view('confirmationannulation');
    }

    /******************** Page accueil  ********************/
    public function showFormAccueil()
    {
        return view('accueil');
    }
    public function accueil(Request $request)
    {
        $messages = [
            'numRueDep.text' => 'Vous devez choisir un numéro de rue.',
            'numRueDep.required' => 'Vous devez choisir un numéro de rue.',

            'adresseRueDep.text' => 'Vous devez choisir une adresse.',
            'adresseRueDep.required' => 'Vous devez choisir une adresse.',

            'villeDep.text' => 'Vous devez choisir une ville.',
            'villeDep.required' => 'Vous devez choisir une ville.',

            'cpDep.integer' => 'Vous devez choisir un code postal.',
            'cpDep.required' => 'Vous devez choisir un code postal.',

            'dateDep.required' => 'Vous devez choisir une date.',
            'dateDep.date' => 'Vous devez choisir une date valide.',
            
            'timeDep.required' => 'Vous devez choisir une heure.',
            'timeDep.date_format' => 'Vous devez choisir une heure valide.',

            'nbPlace.integer' => 'Vous devez choisir un nombre de place.',
            'nbPlace.required' => 'Vous devez choisir un code postal.',

            'numRueArr.text' => 'Vous devez choisir un numéro de rue.',
            'numRueArr.required' => 'Vous devez choisir un numéro de rue.',

            'adresseRueArr.text' => 'Vous devez choisir une adresse.',
            'adresseRueArr.required' => 'Vous devez choisir une adresse.',

            'villeArr.text' => 'Vous devez choisir une ville.',
            'villeArr.required' => 'Vous devez choisir une ville.',

            'cpArr.integer' => 'Vous devez choisir un code postal.',
            'cpArr.required' => 'Vous devez choisir un code postal.',
        ];

        $rules = [
            'dateDep' => ['required', 'date'],
            'timeDep' => ['required', 'date_format:H:i'],
            'numRueDep' => ['required'],
            'adresseRueDep' => ['required'],
            'villeDep' => ['required'],
            'cpDep' => ['required'],
            'nbPlace' => ['required'],
            'numRueArr' => ['required'],
            'adresseRueArr' => ['required'],
            'villeArr' => ['required'],
            'cpArr' => ['required'],
        ];

        $validatedData = $request->validate($rules, $messages);

        $dateDep = $validatedData['dateDep'];
        $timeDep = $validatedData['timeDep'];
        $datetimeDep = "$dateDep $timeDep";
        $numRueDep = $validatedData['numRueDep'];
        $adresseRueDep = $validatedData['adresseRueDep'];
        $villeDep = $validatedData['villeDep'];
        $cpDep = $validatedData['cpDep'];
        $nbPlace = $validatedData['nbPlace'];
        $numRueArr = $validatedData['numRueArr'];
        $adresseRueArr = $validatedData['adresseRueArr'];
        $villeArr = $validatedData['villeArr'];
        $cpArr = $validatedData['cpArr'];

        //Pour récupérer les données saisies par l'utilisateur
        $trajet=$this->repository->createDataRechercheTrajetForm($dateDep, 
            $timeDep, $numRueDep, $adresseRueDep, $villeDep, $cpDep, $nbPlace, $numRueArr, $adresseRueArr,
            $villeArr, $cpArr);

        //Ici fictive, doit returner les résultats de la recherche de l'utilisateur
        $trajetsProposes=$this->data->trajetsProposes();

        try {
            return view('rechercheTrajetResult', ['trajet'=>$trajet, 'trajetsProposes'=>$trajetsProposes]);
        } catch (Exception $exception) {
            return
            redirect()->route('accueil')->withInput()->withErrors("Impossible d\'éffectuer la recherche.");
        }
    }

    /******************** Page recherche trajet  ********************/
    public function showFormRechercheTrajet()
    {
        //Les trajets les moins chers
        $bestTrajets=$this->repository->bestTrajets();
        return view('rechercheTrajet', ['bestTrajets'=>$bestTrajets]);
    }

    public function rechercheTrajet(Request $request)
    {
        $messages = [
            'numRueDep.text' => 'Vous devez choisir un numéro de rue.',
            'numRueDep.required' => 'Vous devez choisir un numéro de rue.',

            'adresseRueDep.text' => 'Vous devez choisir une adresse.',
            'adresseRueDep.required' => 'Vous devez choisir une adresse.',

            'villeDep.text' => 'Vous devez choisir une ville.',
            'villeDep.required' => 'Vous devez choisir une ville.',

            'cpDep.integer' => 'Vous devez choisir un code postal.',
            'cpDep.required' => 'Vous devez choisir un code postal.',

            'dateDep.required' => 'Vous devez choisir une date.',
            'dateDep.date' => 'Vous devez choisir une date valide.',
            
            'timeDep.required' => 'Vous devez choisir une heure.',
            'timeDep.date_format' => 'Vous devez choisir une heure valide.',

            'nbPlace.integer' => 'Vous devez choisir un nombre de place.',
            'nbPlace.required' => 'Vous devez choisir un code postal.',

            'numRueArr.text' => 'Vous devez choisir un numéro de rue.',
            'numRueArr.required' => 'Vous devez choisir un numéro de rue.',

            'adresseRueArr.text' => 'Vous devez choisir une adresse.',
            'adresseRueArr.required' => 'Vous devez choisir une adresse.',

            'villeArr.text' => 'Vous devez choisir une ville.',
            'villeArr.required' => 'Vous devez choisir une ville.',

            'cpArr.integer' => 'Vous devez choisir un code postal.',
            'cpArr.required' => 'Vous devez choisir un code postal.',
        ];

        $rules = [
            'dateDep' => ['required', 'date'],
            'timeDep' => ['required', 'date_format:H:i'],
            'numRueDep' => ['required'],
            'adresseRueDep' => ['required'],
            'villeDep' => ['required'],
            'cpDep' => ['required'],
            'nbPlace' => ['required'],
            'numRueArr' => ['required'],
            'adresseRueArr' => ['required'],
            'villeArr' => ['required'],
            'cpArr' => ['required'],
        ];

        $validatedData = $request->validate($rules, $messages);

        $dateDep = $validatedData['dateDep'];
        $timeDep = $validatedData['timeDep'];
        $datetimeDep = "$dateDep $timeDep";
        $numRueDep = $validatedData['numRueDep'];
        $adresseRueDep = $validatedData['adresseRueDep'];
        $villeDep = $validatedData['villeDep'];
        $cpDep = $validatedData['cpDep'];
        $nbPlace = $validatedData['nbPlace'];
        $numRueArr = $validatedData['numRueArr'];
        $adresseRueArr = $validatedData['adresseRueArr'];
        $villeArr = $validatedData['villeArr'];
        $cpArr = $validatedData['cpArr'];

        $trajet=$this->repository->createDataRechercheTrajetForm($dateDep, 
            $timeDep, $numRueDep, $adresseRueDep, $villeDep, $cpDep, $nbPlace, $numRueArr, $adresseRueArr,
            $villeArr, $cpArr);

        //Ici fictive, doit returner les résultats de la recherche de l'utilisateur
        $trajetsProposes=$this->data->trajetsProposes();

        try {
            return view('rechercheTrajetResult', ['trajet'=>$trajet, 'trajetsProposes'=>$trajetsProposes]);
        } catch (Exception $exception) {
            return
            redirect()->route('rechercheTrajet')->withInput()->withErrors("Impossible d\'éffectuer la recherche.");
        }
    }

    /******************** Page détails résultat recherche trajet  ********************/
   
    public function detailsResultRechercheTrajet(int $trajetId)
    {
        //Données sur un trajet à travers son id
        $UnTrajet = $this->repository->UnTrajet($trajetId);
        //Données sur le conducteur d'un trajet à travers son id
        $UnProfil = $this->repository->UnProfil($trajetId);
        //Données sur les passager d'un trajet à travers son id
        $passagers = $this->repository->passagers($trajetId);
        return view('detailsResultRechercheTrajet', ['UnTrajet' => $UnTrajet, 
        'UnProfil' => $UnProfil, 'passagers' => $passagers]);
    }

    public function reservation()
    {
        //Action à faire lorqu'on clique sur le bouton réserver
        return redirect()->route('accueil');
    }
}

