<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Exception;
use Illuminate\Support\Facades\Cookie;
use App\Repositories\SawdaRepository;
use Illuminate\Http\Request;

class SawdaController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(SawdaRepository $repository)
    {
        $this->repository = $repository;
        $this->nb=1;
    }

    /******************** Page accueil ********************/
    public function showFormAccueil()
    {
        return view('home');
    }

    public function accueil(Request $request, SawdaRepository $repository)
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
        $trajet=$this->repository->createDataRechercheTrajetForm(
            $dateDep, $numRueDep, $adresseRueDep, $villeDep, $cpDep, $nbPlace, $numRueArr, $adresseRueArr,
            $villeArr, $cpArr);

        //Les résultats de la recherche de l'utilisateur
        $trajetsProposes=$this->repository->trajetsProposes($trajet);
        $bestTrajets=$this->repository->bestTrajets();

        try {
            return 
            view('passager.recherche_trajet_result', ['trajet'=>$trajet, 'trajetsProposes'=>$trajetsProposes, 'bestTrajets'=>$bestTrajets]);
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
        return view('passager.recherche_trajet', ['bestTrajets'=>$bestTrajets]);
    }

    public function rechercheTrajet(Request $request, SawdaRepository $repository)
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
        $this->nb=$validatedData['nbPlace'];
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
        $trajet=$this->repository->createDataRechercheTrajetForm(
            $dateDep, $numRueDep, $adresseRueDep, $villeDep, $cpDep, $nbPlace, $numRueArr, $adresseRueArr,
            $villeArr, $cpArr);

        //Les résultats de la recherche de l'utilisateur
        $trajetsProposes=$this->repository->trajetsProposes($trajet);
        $bestTrajets=$this->repository->bestTrajets();

        try {
            return 
            view('passager.recherche_trajet_result', ['trajet'=>$trajet, 'trajetsProposes'=>$trajetsProposes, 'bestTrajets'=>$bestTrajets]);
        } catch (Exception $exception) {
            return
            redirect()->route('passager.recherche_trajet')->withInput()->withErrors("Impossible d\'éffectuer la recherche.");
        }
    }

    /******************** Page détails résultat recherche trajet  ********************/
   
    public function detailsResultRechercheTrajet(int $trajetId, SawdaRepository $repository)
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

    public function showFormNvMsg(Request $request, SawdaRepository $repository)
    {
        /*Si on suppose que pour la page de connexion il existe
        Un code qui permet de se souvenir de l'authentification de l'utilisateur
        $value=$this->repository->getUserId($email, $password);
        $key='idUser';
        $request->session()->put($key, $value); 
        $teams=$this->repository->teams();
        if (!$request->session()->has('idUser')) {
            return redirect(route('connexion'));
        }
        $idProfil = $request->session()->get('idUser');*/
        $idProfil = 101;
        $trajetsReservations= $this->repository->trajetsReservationsProfil($idProfil);
        return view('commun.nouveau_message', ['trajetsReservations'=>$trajetsReservations]);
    }

    public function nvMsg(Request $request) 
    {
        /*Si on suppose que pour la page de connexion il existe
        Un code qui permet de se souvenir de l'authentification de l'utilisateur
        $value=$this->repository->getUserId($email, $password);
        $key='idUser';
        $request->session()->put($key, $value); 
        $teams=$this->repository->teams();
        if (!$request->session()->has('idUser')) {
            return redirect(route('connexion'));
        }
        $idProfil = $request->session()->get('idUser');*/
        $idProfil = 101;
        $messagesProfil= $this->repository->messagesProfil($idProfil);

        $messages = [
            'destinataire.required' => 'Vous devez choisir un.e destinataire.',
            'destinataire.exists' => 'Vous devez choisir un.e destinataire qui existe.',
            'objet.required' => 'Vous devez écrire un objet.',
            'message.required' => 'Vous devez écrire un message.'
        ];

        $rules = [
            'destinataire' => ['required'],
            'objet' => ['required'],
            'message' => ['required']
        ];

        $validatedData = $request->validate($rules, $messages);

        $msg=[
            'objet'=>$validatedData['objet'],
            'texteMessage'=>$validatedData['message'],
            'idEmetteur'=>$idProfil,
            'idDestinataire'=>$validatedData['destinataire']
        ];
        $this->repository->insertMsg($msg);
        try {
            return redirect()->route('messages.all', ['messagesProfil' => $messagesProfil]);
        }catch (Exception $exception) {
            return 
            redirect()->route('messages.new')->withInput()->withErrors("Impossible de créer le match.");
        }
    }

    public function showFormMsg(Request $request, SawdaRepository $repository)
    {
        /*Si on suppose que pour la page de connexion il existe
        Un code qui permet de se souvenir de l'authentification de l'utilisateur
        $value=$this->repository->getUserId($email, $password);
        $key='idUser';
        $request->session()->put($key, $value); 
        $teams=$this->repository->teams();
        if (!$request->session()->has('idUser')) {
            return redirect(route('connexion'));
        }
        $idProfil = $request->session()->get('idUser');*/
        $idProfil = 101;
        $messagesProfil= $this->repository->messagesProfil($idProfil);
        return view('commun.mes_messages', ['messagesProfil' => $messagesProfil]);
    }

    public function showFormRepondreMsg(int $msgId,SawdaRepository $repository,Request $request)
    {
        /*Si on suppose que pour la page de connexion il existe
        Un code qui permet de se souvenir de l'authentification de l'utilisateur
        $value=$this->repository->getUserId($email, $password);
        $key='idUser';
        $request->session()->put($key, $value); 
        $teams=$this->repository->teams();
        if (!$request->session()->has('idUser')) {
            return redirect(route('connexion'));
        }
        $idProfil = $request->session()->get('idUser');*/
        $idProfil =101;
        $unMessages= $this->repository->unMessages($msgId);
        return view('commun.repondre_message', 
        ['unMessages' => $unMessages], ['idProfil' => $idProfil]);
    }

    public function repondreMsg(Request $request,SawdaRepository $repository)
    {
        /*Si on suppose que pour la page de connexion il existe
        Un code qui permet de se souvenir de l'authentification de l'utilisateur
        $value=$this->repository->getUserId($email, $password);
        $key='idUser';
        $request->session()->put($key, $value); 
        $teams=$this->repository->teams();
        if (!$request->session()->has('idUser')) {
            return redirect(route('connexion'));
        }
        $idProfil = $request->session()->get('idUser');*/
        $idProfil =101;
        $messagesProfil= $this->repository->messagesProfil($idProfil);
        $messages = [
            'message.required' => "Vous devez saisir un message.",
            'objet.required' => "Vous devez saisir un message.",
            'idEmetteur.required' => "Vous devez saisir un message.",
            'idDestinataire.required' => "Vous devez saisir un message."
          ];
        $rules = ['message' => ['required'], 'objet' => ['required'],
        'idEmetteur' => ['required'], 'idDestinataire' => ['required']];
        $validatedData = $request->validate($rules, $messages);
        $msg=[
            'objet'=>$validatedData['objet'],
            'texteMessage'=>$validatedData['message'],
            'idEmetteur'=>$validatedData['idEmetteur'],
            'idDestinataire'=>$validatedData['idDestinataire']
        ];
        $msgId=$this->repository->insertMsg($msg);
        try {
            return redirect()->route('messages.reply', ['msgId' => $msgId]);
            //return redirect()->route('messages.all', ['messagesProfil' => $messagesProfil]);
        }catch (Exception $exception) {
            return 
            redirect()->route('messages.reply')->withInput()->withErrors("Impossible d'envoyer le message.");
        }
    }

    public function supprimerMsg(Request $request,SawdaRepository $repository)
    {
        /*Si on suppose que pour la page de connexion il existe
        Un code qui permet de se souvenir de l'authentification de l'utilisateur
        $value=$this->repository->getUserId($email, $password);
        $key='idUser';
        $request->session()->put($key, $value); 
        $teams=$this->repository->teams();
        if (!$request->session()->has('idUser')) {
            return redirect(route('connexion'));
        }
        $idProfil = $request->session()->get('idUser');*/
        $idProfil =101;
        $messagesProfil= $this->repository->messagesProfil($idProfil);
        $messages = [
            'idMessage.required' => "Vous devez saisir un message."
          ];
        $rules = ['idMessage' => ['required']];
        $validatedData = $request->validate($rules, $messages);
        $msgId=$validatedData['idMessage'];
        $this->repository->deleteMsg($msgId);
        try {
            return redirect()->route('acceuil');
        }catch (Exception $exception) {
            return 
            redirect()->route('messages.all')->withInput()->withErrors("Impossible de supprimer le message.");
        }
    }

    public function reserver(Request $request,SawdaRepository $repository)
    {
        /*Si on suppose que pour la page de connexion il existe
        Un code qui permet de se souvenir de l'authentification de l'utilisateur
        $value=$this->repository->getUserId($email, $password);
        $key='idUser';
        $request->session()->put($key, $value); 
        $teams=$this->repository->teams();
        if (!$request->session()->has('idUser')) {
            return redirect(route('connexion'));
        }
        $idProfil = $request->session()->get('idUser');*/
        $idProfil =101;
        $reservation=[
            'dateHeureRDV' =>$request->input('dateHeureRDV'),
            'prixResa' =>$request->input('prixResa'),
            'idLieuRencontre' =>$request->input('idLieuRencontre'),
            'idLieuDepot' =>$request->input('idLieuDepot'),
            'idPassager' =>$idProfil,
            'idTrajet' =>$request->input('idTrajet'),
            'nbPlace' =>$this->nb
        ];
        $reservation=$this->repository->insertReservation($reservation);
        try {
        return redirect()->route('reservation_en_cours'/*, ['idProfil' => $idProfil]*/);
        }catch (Exception $exception) {
            return 
            redirect()->route('reservation')->withInput()->withErrors("Impossible de faire la réservation.");
        }
    }
}
