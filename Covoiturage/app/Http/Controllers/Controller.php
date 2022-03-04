<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    /* ----------------- Fonctions pour les pages se trouvant dans le dossier commun ----------------- */

    // Page de profil (contenant tout les accès aux différents pages )
    public function showUserPage() {
        return view('commun.user');
    }

    // Page de l'historique des trajets d'un utilisateur
    public function showHistoriqueTrajet() {
        return view('commun.historique_trajets');
    }

    // page modification de profil
    public function showModificationProfilForm(Request $request) {
        /*
        if(!$request->session()->has('user'))
            return redirect()->route('connexion');
        */
        return view('commun.modification_profil');
    }

    // Bouton modifier info personnelles
    public function modifyProfil() {
        /* TODO */
        return view('commun.modification_profil');
    }

    // Page Mes messages
    public function showMesMessages() {
        return view('commun.mes_messages');
    }

    // Page Informations personnelles
    public function showInfosPerso(){
        return view('commun.informations_personnelles');
    }

    // Bouton modifier info technique
    public function modifyTechnique() {
        /* TODO */
        return view('commun.modification_technique');
    }

    // Page modification technique
    public function showModificationTechniqueForm() {
        return view('commun.modification_technique');
    }

    // PAge ecrire un nouveau message
    public function showEcrireMessageForm(){
        return view('commun.nouveau_message');
    }

    // Bouton traitement nouv message
    public function newMessage() {
        /* TODO */
        return view('commun.nouveau_message');
    }


    //Page Repondre a un message
    public function showMessagesReply() {
        return view('commun.repondre_message');
    }

    // Page Notation
    public function showNotation() {
        return view('commun.notation');
    }

    public function showCaracteristique() {
        return view('commun.caracteristiques');
    }



    /* ----------------- Fonctions pour les pages se trouvant dans le dossier conducteur ----------------- */

    public function showTrajetEnCours() {
        return view('conducteur.trajets_en_cours');
    }

    public function showAnnulerTrajet() {
        return view('conducteur.annuler_trajet');
    }

    public function showConfirmAnnulationTrajet() {
        return view('conducteur.confirmation_annuler_trajets');
    }

    public function showProposerTrajetForm(){
        return view('conducteur.proposer_trajet');
    }

    /* ----------------- Fonctions pour les pages se trouvant dans le dossier passager ----------------- */


    public function showReservationEnCours() {
        return view('passager.reservation_en_cours');
    }


    public function showAnnulerReservation() {
        return view('passager.annuler_reservation');
    }

    public function showConfirmAnnulationReservation() {
        return view('passager.confirmation_annuler_reservation');
    }

    public function showPayementForm() {
        return view('passager.payement');
    }

    public function showRechercheTrajet() {
        return view('passager.recherche_trajet');
    }

    public function showDetailRechercheTrajet() {
        return view('passager.details_result_recherche_trajet');
    }


    /* ----------------- Fonctions pour les pages restantes ----------------- */

    public function showQuiSommesNous() {
        return view('qui_sommes_nous');
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

    public function testButton() {
        return redirect()->route('inscription');
    }

    public function showReinitialisationMdp() {
        return view('reinitialisation_mdp');
    }

    public function showAPropos() {
        return view('apropos');
    }

    public function showHome() {
        return view('home');
    }
}
