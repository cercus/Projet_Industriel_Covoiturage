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

    // FOnction pour afficher la page de connexion
    public function showConnexionForm() {
        return view('connexion');
    }

    public function showreinitInputEmail() {
        return view('reinitInputEmail');
    }
}
