<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Mail\QuestionMail;
use App\Mail\ReinitMail;

class MailsController extends Controller
{
    public function showQuestion() {
        return view('question');
    }

    /* Fonction pour traiter une question d'un utilisateur (dans la page question.php) */
    public function storeQuestion(Request $request) {

        $messages = [
            'email.required' => 'Vous devez entrer une adresse mail.',
            'objet.required' => 'Vous devez entrer un sujet.',
            'message.required' => 'Vous devez entrer un message.'
        ];

        $rules = [
            'email' => ['required'],
            'objet' => ['required'],
            'message' => ['required']
        ];

        $validatedData = $request->validate($rules, $messages);
        Mail::to("columiny@gmail.com")->queue(new QuestionMail($validatedData));
        return back()->with('success', 'La question a bien été envoyé');

    }

    // mail pour reinitialisation du mot de passe
    public function storeReinit(Request $request) {

        $messages = [
            'email.required' => 'Vous devez entrer une adresse mail.'
        ];

        $rules = [
            'email' => ['required']
        ];

        $validatedData = $request->validate($rules, $messages);
        //Mail::to('n.dufthir@gmail.com')->queue(new ReinitMail($validatedData));
        Mail::to($validatedData['email'])->queue(new ReinitMail($validatedData));
        //var_dump($validatedData['email']);
        return back()->with('success', 'Le lien de réinitialisation a bien envoyé');

    }
}
