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
use Illuminate\Support\Facades\Validator;

class DorianController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(DorianRepository $dorianRepository) 
    {
        $this->dorianRepository  = $dorianRepository;
    }

    /**
     * FOnction pour retourner la vue proposre un trajet
     */
    public function showProposerTrajetForm(){
        return view('conducteur.proposer_trajet');
    }

    /**
     * Fonction pour stocker un trajet
     */
    public function storeProposerTrajetForm(Request $request) {
        //return $request->json()->all();
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
        $this->dorianRepository->insertTrajet($validator->validated());
        return $request->json()->all();
        
    }

    /**
     * Fonction pour afficher la vue historique trajet
     */
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


    /**
     * FOnction pour afficher la vue notation
     */
    public function showTrajetForNotation($idUtilisateur, $idReservation) {
        $idTrajet = $this->dorianRepository->getIdTrajetFromIdReservation($idReservation, $idUtilisateur);
        $trajetsConducteur = $this->dorianRepository->getTrajetWithIdTrajetAndIdReservationConducteur($idUtilisateur, $idTrajet, $idReservation);
        $trajetsPassager = $this->dorianRepository->getTrajetWithIdTrajetAndIdReservationPassager($idUtilisateur, $idTrajet, $idReservation);
        return view('commun.notation', ['trajetConducteur' => $trajetsConducteur, 'trajetPassager' => $trajetsPassager]);
    }

    // Les passagers notent les conducteurs
    public function showTrajetForNotationPassager($idUtilisateur, $idReservation) {
        return view('commun.notationPassager', ["trajet" => $this->dorianRepository->getTrajetFromIdReservation($idReservation)]);
    }

    public function showTrajetForNotationConducteur($idUtilisateur, $idReservation) {
        return view('commun.notationConducteur', ['trajet'=> $this->dorianRepository->getTrajetFromIdReservation($idReservation)]);
    }

    /* Fonction pour noter un conducteur après un trajet (storeNotationConducteur) */ 
    public function storeNotationConducteur(Request $request, $idUtilisateur, $idReservation) {
        
        $rules = [
            "message" => ['nullable'],
            "star1" => ["nullable"],
            "star2" => ["nullable"],
            "star3" => ["nullable"],
            "star4" => ["nullable"],
            "star5" => ["nullable"],
        ]; 

        $messages = [];

        $validatedData = $request->validate($rules, $messages);
        $note = 0;
        if(isset($validatedData['star5']))
            $note = $validatedData['star5'];
        else if(isset($validatedData['star4']))
            $note = $validatedData['star4'];
        else if(isset($validatedData['star3']))
            $note = $validatedData['star3'];
        else if(isset($validatedData['star2']))
            $note = $validatedData['star2'];
        else if(isset($validatedData['star1']))
            $note = $validatedData['star1'];
        $this->dorianRepository->insertNotation($note, $validatedData['message'], $idReservation, $idUtilisateur);
        return redirect()->route('user');
        
    }

    /**
     * FOnction pour stocker une notation
     */
    public function storeNotationPassager(Request $request, $idUtilisateur, $idReservation) {
        
        $rules = [
            "message" => ['nullable'],
            "star1" => ["nullable"],
            "star2" => ["nullable"],
            "star3" => ["nullable"],
            "star4" => ["nullable"],
            "star5" => ["nullable"],
        ]; 

        $messages = [];

        $validatedData = $request->validate($rules, $messages);
        $note = 0;
        if(isset($validatedData['star5']))
            $note = $validatedData['star5'];
        else if(isset($validatedData['star4']))
            $note = $validatedData['star4'];
        else if(isset($validatedData['star3']))
            $note = $validatedData['star3'];
        else if(isset($validatedData['star2']))
            $note = $validatedData['star2'];
        else if(isset($validatedData['star1']))
            $note = $validatedData['star1'];
        $this->dorianRepository->insertNotation($note, $validatedData['message'], $idReservation, $idUtilisateur);
        return redirect()->route('home');
        
    }

}