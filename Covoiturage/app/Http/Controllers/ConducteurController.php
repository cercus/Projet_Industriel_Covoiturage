<?php

namespace App\Http\Controllers;

use DateTime;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

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
            //if($this->repository->userVoiture(session()->has('user')['id']))
            return view('conducteur.proposer_trajet');
        
        return redirect()->route('connexion');
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
        $this->repository->insertTrajet($validator->validated(), session()->get('user')['id']);
        return $request->json()->all();
    }

    public function showTrajetEnCours($idConducteur)
    {
        if(!session()->has('user'))
            return redirect()->route('accueil');
        if(session()->get('user')['id'] != $idConducteur)
            return redirect()->route('accueil');
        $trajetsEnCours = $this->repository->trajetEnCours($idConducteur);
        $tailleTableau = count($trajetsEnCours);
        $tableTime = [];
        $tabDateFrenche =[];
        //tableau pour récupérer les passagers d'un trajet
        $passagers = [];
        for ($i=0; $i < $tailleTableau ; $i++) {
            //pour calucler le temps d'un trajet
            $date1 = new DateTime($trajetsEnCours[$i]->dateHeureDepart);
            $date2 = new DateTime($trajetsEnCours[$i]->dateHeureArrivee);
            $differenceHours = $date1->diff($date2)->h;
            $differenceMinutes = $date1->diff($date2)->i;
            $timeTrajet = $differenceMinutes + ($differenceHours*60);
            $tableTime[$i]= $timeTrajet;
            //pour traduire la date en francais
            setlocale(LC_TIME, 'french');
            $dateFrench = strftime("%a %d/%m", strtotime($trajetsEnCours[$i]->dateHeureDepart));
            $tabDateFrenche[$i] = $dateFrench;
            //pour récupérer les passagers d'un trajet
            $passagers[$i] = $this->repository->passagersDuTrajet($trajetsEnCours[$i]->idTrajet);
        }
        return view('/conducteur/trajets_en_cours', ['trajetsEnCours' => $trajetsEnCours, 
                                                     'tableTime' => $tableTime,
                                                     'tabDateFrenche' => $tabDateFrenche,
                                                     'passagers' => $passagers
                                                     ]);
    }

    //function pour valider un passager par un conducteur
    public function validerPassager(Request $request, $idReservation)
    {
        if(!session()->has('user'))
            return redirect()->route('home');
        $idConducteur = $request->session()->get('user')['id'];
        $nbrPlacesMax = $this->repository->nbrPlacesMax($request->idTrajet);
        $nbrPassagerAcceptes = $this->repository->nbrPassagerAcceptes($request->idTrajet);
        //pour ne pas dépassé nombre de places max autorisées
        if($nbrPlacesMax >= ($nbrPassagerAcceptes * $request->nbrplaces)) {
            DB::table('Reservations')->where('idReservation', $idReservation)->update(['estAccepte' => 1]);
            $this->repository->AvertirAcceptationPassager($idConducteur, $request->idPassager);
            return redirect()->back();
        }
        return redirect()->back()->with('errors', 'Vous avez dépassé le nombre maximum de places autorisées.');          
    }

    //function pour refuser un passager par un conducteur
    public function refuserPassager(Request $request, $idReservation)
    {
        if(!session()->has('user'))
            return redirect()->route('home');
        $idConducteur = $request->session()->get('user')['id'];
        $this->repository->AvertirRejetPassager($idConducteur, $request->idPassager);
        DB::table('Reservations')->where('idReservation', $idReservation)->delete();
        return redirect()->back();
    }

    public function showAnnulerTrajet($idTrajet) 
    {   
        if(!session()->has('user'))
            return redirect()->route('home');
        $idConducteur = Request()->session()->get('user')['id'];
        $estMonTrajets = $this->repository->estMonTrajet($idConducteur, $idTrajet);
        
        if($estMonTrajets == 0){
            return redirect()->route('trajets_en_cours',['idConducteur' => $idConducteur])
                             ->with('errors', "Ce n'est pas votre trajet.");
        }
        return view('/conducteur/annuler_trajet', ['idConducteur' => $idConducteur, 'idTrajet' => $idTrajet]);
    }
    
    public function acceptAnnulerTrajet(Request $request, $idTrajet)
    {   
        if(!session()->has('user'))
            return redirect()->route('home');
        $idConducteur = Request()->session()->get('user')['id'];
        $passagers = $this->repository->passagersDuTrajet($idTrajet);
        $rules = ['motif-annulation' => ['required']];
        $messages = ['motif-annulation.required' => "Vous devez saisir le motif d'annulation"];
        $validatedData = $request->validate($rules, $messages);
        $motif = $request->input('motif-annulation');
        $message = $request->input('message-conducteur');
        if ($message == null)
            $texteMessage = "Nous avons le regret de vous informer que le conducteur a récemment annulé le trajet que vous avez réservé sans vous laisser de message en raison de : \n$motif";
        else
            $texteMessage = "Motif : $motif \nMessage du conducteur : $message";
        foreach ($passagers as $passager) {
            DB::table('Messages')->insertGetId(['objet' => 'Annulation du trajet',
                                        'dateMessage' => NOW(),
                                        'texteMessage' => $texteMessage,
                                        'idEmetteur' => $idConducteur,
                                        'idDestinataire' => $passager->idPassager]);
        }
        DB::table('Reservations')->where('idTrajet', $idTrajet)->delete();
        DB::table('Trajets')->where('idTrajet', $idTrajet)->delete();
        return redirect()->route('confirmation_annuler_trajets');        
    }

    

}