<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Validator;

class ConducteurController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(Repository $Repository) 
    {
        $this->repository  = $Repository;
    }

    /* ====== Page Proposer un trajet ====== */

    public function showProposerTrajetForm(){
        if(session()->has('user'))
            if($this->repository->userVoiture(session()->has('user')['id']))
                return view('conducteur.proposer_trajet');
        
        return redirect()->route('accueil');
    }

    /**
     * Fonction pour valider le formulaire d'insertion d'un nouveau trajet
     */
    public function storeProposerTrajet(Request $request) {
        $messages = [
            'rueDep.required' => "Vous devez entrer un nom de voie de départ.",
            'cpDep.required' => "Vous devez entrer un code postal de départ.",
            'villeDep.required' => "Vous devez entrer une ville de départ.",
            'rueArr.required' => "Vous devez entrer un nom de voie d'arrivée.",
            'cpArr.required' => "Vous devez entrer un code postal d'arrivée.",
            'villeArr.required' => "Vous devez entrer une ville d'arrivée.",
            'prix.required' => "Vous devez entrer un prix",
            'prix.min' => "Le montant minimum est de 1€",
            'prix.max' => "Le montant maximal est de 10€",
            'prix.between' => "Le prix n'est pas compris entre 1 et 10€.",
            'date.after' => "La date specifié est inférieur à la date d'aujourd'hui.",
            'date.required' => "Vous devez entrer une date.",
            'nbPlace.required' => "Vous devez entrer un nombre de place"
            
        ];
        $rules = [
            'numRueDep' => ['nullable'],
            'rueDep' => ['required'],
            'cpDep' => ['required'],
            'villeDep' => ['required'],
            'numRueArr' => ['nullable'],
            'rueArr' => ['required'],
            'cpArr' => ['required'],
            'villeArr' => ['required'],
            'prix' => ['required', 'integer', 'between:1,10'],
            'place' => ['required'],
            'dateDepart' => ['required', 'after:'.date(DATE_ATOM, time())],
            'debutLat' => ['required'],
            'debutLon' => ['required'],
            'finLat' => ['required'],
            'finLon' => ['required'],
            'tempsTrajet' => ['required']
            
        ];
        $validator = Validator::make($request->json()->all(), $rules, $messages);

        if($validator->failed()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $this->repository->insertTrajet($validator->validated(), 1);
        return $request->json()->all();
    }
}