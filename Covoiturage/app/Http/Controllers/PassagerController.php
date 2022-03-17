<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Validator;
use Exception;

class PassagerController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(Repository $Repository) 
    {
        $this->repository  = $Repository;
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
            'dateDep' => ['required'],
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
        $numRueDep = $validatedData['numRueDep'];
        $adresseRueDep = $validatedData['adresseRueDep'];
        $villeDep = $validatedData['villeDep'];
        $cpDep = $validatedData['cpDep'];
        $nbPlace = $validatedData['nbPlace'];
        $numRueArr = $validatedData['numRueArr'];
        $adresseRueArr = $validatedData['adresseRueArr'];
        $villeArr = $validatedData['villeArr'];
        $cpArr = $validatedData['cpArr'];

        /*$trajet= [
            'dateDep' => '2022-02-21 07:00:00',
            'numRueDep' => 'rue',
            'adresseRueDep' => 'rue',
            'villeDep' => 'Marseille',
            'cpDep' => 13013,
            'nbPlace' => 3,
            'numRueArr' => 3,
            'adresseRueArr' => 'rue',
            'villeArr' => 'Marseille',
            'cpArr' => 13009
        ];*/

        //Pour récupérer les données saisies par l'utilisateur
        $trajet=$this->repository->createDataRechercheTrajetForm($dateDep, $numRueDep, $adresseRueDep, $villeDep, $cpDep, $nbPlace, $numRueArr, $adresseRueArr, $villeArr, $cpArr);

        //Les résultats de la recherche de l'utilisateur
        $trajetsProposes=$this->repository->trajetsProposes($trajet);
        $bestTrajets=$this->repository->bestTrajets();

        try {
            return  view('passager.recherche_trajet_result', ['trajet'=>$trajet, 'trajetsProposes'=>$trajetsProposes, 'bestTrajets'=>$bestTrajets]);
        } catch (Exception $exception) {
            return redirect()->route('passager.recherche_trajet')->withInput()->withErrors("Impossible d\'éffectuer la recherche.");
        }
    }

    public function showFormRechercheTrajet()
    {
        //Les trajets les moins chers
        $bestTrajets=$this->repository->bestTrajets();
        return view('passager.recherche_trajet', ['bestTrajets'=>$bestTrajets]);
    }

    public function detailsResultRechercheTrajet(int $trajetId)
    {
        //Données sur un trajet à travers son id
        $unTrajet = $this->repository->unTrajet($trajetId);
        //Données sur le conducteur d'un trajet à travers son id
        $unProfil = $this->repository->unProfil($trajetId);
        //Données sur le conducteur d'un trajet à travers son id
        $uneNote = $this->repository->uneNote($unProfil['idUtilisateur']);
        //Données sur les passager d'un trajet à travers son id
        $passagers = $this->repository->passagers($trajetId);
        return view('passager.details_result_recherche_trajet', ['unTrajet' => $unTrajet, 
        'unProfil' => $unProfil, 'uneNote' => $uneNote, 'passagers' => $passagers]);
    }

    public function reservation()
    {
        //Action à faire lorqu'on clique sur le bouton réserver
        return redirect()->route('accueil');
    }
}