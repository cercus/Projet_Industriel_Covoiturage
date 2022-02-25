<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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

    public function showModificationProfilForm(Request $request) {
        /*
        if(!$request->session()->has('user'))
            return redirect()->route('connexion');
        */
        return view('modification_profil');
    }

    public function testButton() {
        return redirect()->route('inscription');
    }

    public function showInfosPerso(){
        return view('informations_personnelles');
    }

    public function modifyProfil() {
        return view('modification_profil');
    }

    public function modifyTechnique() {
        return view('modification_technique');
    }

    public function showModificationTechniqueForm() {
        return view('modification_technique');
    }

    public function showMesMessages() {
        return view('mes_messages');
    }

    public function showEcrireMessageForm(){
        return view('nouveau_message');
    }

    public function newMessage() {
        return view('nouveau_message');
    }

    public function showMessagesReply() {
        return view('repondre_message');
    }
}
