<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Repositories\Repository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Exception;

class PassagerController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(Repository $Repository) 
    {
        $this->repository  = $Repository;
        $this->nb = 1;
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
        $this->nb = $validatedData['nbPlace'];
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
            return redirect()->route('passager.recherche_trajet')->withInput()->withErrors("Impossible d'éffectuer la recherche.");
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

    public function showReservationEnCours($idPassager) {
        if(!session()->has('user'))
            return redirect()->route('accueil');
        //if(session()->get('user')['id'] != $idPassager)
        //    return redirect()->route('home');
        // les reservations en cours d'un passager
        $reservationsEnCours = $this->repository->reservationsEnCours($idPassager);
        $tableTime = [];
        $tabDateFrenche =[];
        $conducteurs =[];
        for ($i=0; $i < count($reservationsEnCours) ; $i++) {
            //pour calucler le temps d'un trajet
            $date1 = new DateTime($reservationsEnCours[$i]->dateHeureDepart);
            $date2 = new DateTime($reservationsEnCours[$i]->dateHeureArrivee);
            $differenceHours = $date1->diff($date2)->h;
            $differenceMinutes = $date1->diff($date2)->i;
            $tableTime[$i] = $differenceMinutes + ($differenceHours*60);
            //pour traduire la date en francais
            setlocale(LC_TIME, 'french');
            $dateFrench = strftime("%a %d/%m", strtotime($reservationsEnCours[$i]->dateHeureDepart));
            $tabDateFrenche[$i] = $dateFrench;
            //Récupération des conducteurs à partir des réservations de passagers
            $conducteurs[$i] = $this->repository->quiConducteur($reservationsEnCours[$i]->idTrajet);
        }
        return view('passager.reservation_en_cours', ['reservationsEnCours' => $reservationsEnCours,
                                                      'tableTime' => $tableTime,
                                                      'tabDateFrenche' => $tabDateFrenche,
                                                      'conducteurs' => $conducteurs]);
    }


    public function showAnnulationReservation($idReservation) {
        if(!session()->has('user'))
            return redirect()->route('connexion');
        $idPassager = session()->get('user')['id'];

        //pour ne pas acceder à une réservation d'autre utilisateur 
        $estMaReservation = $this->repository->existeReservation($idReservation, $idPassager);
        if($estMaReservation == 0){
            return redirect()->route('reservation_en_cours',['idPassager' => $idPassager])
                             ->with('errors', "Ce n'est pas votre réservation.");
        }
        return view('/passager/annuler_reservation', ['idReservation' => $idReservation]);
    }

    public function acceptAnnulerReservation(Request $request, $idReservation)
    {   
        if(!session()->has('user'))
            return redirect()->route('connexion');
        $idPassager = Request()->session()->get('user')['id'];
        $monConducteur = $this->repository->quiMonConducteur($idReservation)[0];
        
        $rules = ['motif-annulation' => ['required']];
        $messages = ['motif-annulation.required' => "Vous devez saisir le motif d'annulation"];
        $validatedData = $request->validate($rules, $messages);
        $motif = $request->input('motif-annulation');
        $message = $request->input('message-passager');
        if($message == null)
            $texteMessage = "Nous avons le regret de vous informer que votre passager a récemment annulé sa réservation sans vous laisser de message en raison de : \n$motif";
        else
            $texteMessage = "Motif : $motif \nMessage du passager : $message";
        DB::table('Messages')->insertGetId(['objet' => 'Annulation de réservation',
                                    'dateMessage' => NOW(),
                                    'texteMessage' => $texteMessage,
                                    'idEmetteur' => $idPassager,
                                    'idDestinataire' => $monConducteur->idUtilisateur]);
        
        DB::table('Reservations')->where('idReservation', $idReservation)->delete();
        return redirect()->route('confirmation_annuler_reservation');        
    }

    public function showConfirmAnnulationReservation() 
    {
        if(!session()->has('user'))
            return redirect()->route('connexion');
        $idPassager = Request()->session()->get('user')['id'];
        return view('passager.confirmation_annuler_reservation', ['idPassager' => $idPassager]);
    }


    public function reserver(Request $request) {
        if(!session()->has('user'))
            return redirect()->route('connexion');
        $idProfil = session()->get('user')['id'];
        $reservation=[
            'dateHeureRDV' =>$request->input('dateHeureRDV'),
            'prixResa' =>$request->input('prixResa'),
            'idLieuRencontre' =>$request->input('idLieuRencontre'),
            'idLieuDepot' =>$request->input('idLieuDepot'),
            'idPassager' =>$idProfil,
            'idTrajet' =>$request->input('idTrajet'),
            'nbPlace' =>$this->nb
        ];
        //dd($reservation);
        $reservation=$this->repository->insertReservation($reservation);
        try {
            return redirect()->route('reservation_en_cours', ['idPassager' => $idProfil]);
        }catch (Exception $exception) {
            return redirect()->route('reservation')->withInput()->withErrors("Impossible de faire la réservation.");
        }
    }
}