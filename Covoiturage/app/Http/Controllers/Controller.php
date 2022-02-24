<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
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

    // Fonction pour afficher la page de connexion
    public function showConnexionForm() {
        return view('connexion');
    }

    // Fonction pour afficher la page de recherche un trajet
    public function showSearchRoute() {
        return view('search_route');
    }
}
