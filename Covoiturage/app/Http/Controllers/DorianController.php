<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use App\Repositories\DorianRepository;
use Illuminate\Contracts\Support\ValidatedData;

class DorianController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(DorianRepository $dorianRepository) 
    {
        $this->dorianRepository  = $dorianRepository;
    }

    public function showProposerTrajetForm(){
        return view('conducteur.proposer_trajet');
    }

    public function storeProposerTrajetForm(Request $request) {

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
            'date' => ['required', 'after:'.date(DATE_ATOM, time())]
        ];
        $validatedData = $request->validate($rules, $messages);
        try {
            
            $trajet = [
                "numRueDep" => $validatedData['numRueDep'],
                "rueDep" => $validatedData['rueDep'],
                "villeDep" => $validatedData['villeDep'],
                "cpDep" => $validatedData['cpDep'], 
                "numRueArr" => $validatedData['numRueArr'],
                "rueArr" => $validatedData['rueArr'],
                "villeArr" => $validatedData['villeArr'],
                "cpArr" => $validatedData['cpArr'],
                "dateDepart" => $validatedData['date'],
                "place" => $validatedData['place'],
                "prix" => $validatedData['prix'],
                "distance" => $request->input("distance"),
                "tempsTrajet" => $request->input("temps"),
                "debutLon" => $request->input("debutLon"),
                "debutLat" => $request->input("debutLat"),
                "finLon" => $request->input("finLon"),
                "finLat" => $request->input("finLat"),
                "polyline" => $request->input("polyline")

            ];

            //$this->dorianRepository->insertTrajet($trajet);
            //return response()->json(['success'=>'Successfully']);
            return redirect()->route('trajets_en_cours')->withInput()->with('success', 'Le trajet a bien été crée');
        } catch(Exception $exception) {
            return response()->json(array('error' =>$exception->getMessage()), 400);
            //return redirect()->back()->withInput()->withErrors($exception->getMessage()." ->".$exception->getLine()." -> ".$exception->getFile());
        }
    }


    public function showHistoriqueTrajet($idUtilisateur) {
        $trajetsConducteur = $this->dorianRepository->getAllTrajetsConducteur($idUtilisateur);
        $trajetsPassager = $this->dorianRepository->getAllTrajetsPassager($idUtilisateur);
        return view('commun.historique_trajets', ['trajetsConducteur' => $trajetsConducteur, 'trajetsPassager' => $trajetsPassager]);
    }

    public function storeTestAjax(Request $request) {
        $request->validate([
            'name'          => 'required',
            'email'         => 'required|email',
            'mobile'        => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'message'       => 'required',
        ]);

        return response()->json(['success'=>'Successfully']);
    }

}