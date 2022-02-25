<?php

use App\Http\Controllers\LocalizationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\MailsController;
use App\Http\Middleware\Localization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route qui permet de connaître la langue active
Route::get('locale', [LocalizationController::class, 'getLang'])->name('getlang');

// Route qui permet de modifier la langue
Route::get('locale/{lang}', [LocalizationController::class, 'setLang'])->name('setlang');

// Route test lang
Route::get('/testLang',function () {
    return view('testLang');
});

//Route pour la page de profil 
Route::get('/user', function () {
    return view('user');
});

// Route pour la page Poser une question
Route::get('/question', [Controller::class, 'showQuestionForm'])->name('question');
Route::post('/question', [MailsController::class, 'storeQuestion'])->name('store.question');

// ROute Page A propos
Route::get('/apropos', function () {
    return view('apropos');
});



// Route pour la page Inscription
Route::get('/inscription', [Controller::class, 'showInscriptionForm'])->name('inscription');

// Route pour la page de connexion
Route::get('/connexion', [Controller::class, 'showConnexionForm'])->name('connexion');
Route::post('/connexion', [Controller::class, 'storeConnexion'])->name('store.connexion');


//Page qui sommes nous
Route::get('/quisommesnous', [Controller::class, 'quisommesnous'])->name('quisommesnous');

//Page qui sommes nous
Route::get('/paiement', [Controller::class, 'paiement'])->name('paiement');

//Page cofirmation d'annulation
Route::get('/confirmationannulation', [Controller::class, 'confirmationannulation'])->name('confirmationannulation');

//Page accueil
Route::get('/', [Controller::class, 'showFormAccueil'])->name('accueil');
Route::post('/', [Controller::class, 'accueil'])->name('accueil.post');


//Page résultats de la recherche de trajets
Route::get('/rechercheTrajet', [Controller::class, 'accueil'])->name('rechercheTrajetResultDeAccueil');
Route::get('/rechercheTrajet', [Controller::class, 'rechercheTrajet'])->name('rechercheTrajetResultDeTrajet');

//Page recherche trajets
Route::get('/rechercheTrajet', [Controller::class, 'showFormRechercheTrajet'])->name('rechercheTrajet');
Route::post('/rechercheTrajet', [Controller::class, 'rechercheTrajet'])->name('rechercheTrajet.post');

//Page détails résultat recherche trajet
Route::get('/detailsResultRechercheTrajet/{trajetId}', [Controller::class, 'detailsResultRechercheTrajet'])->where('trajetId', '[0-9]+')->name('detailsResultRechercheTrajet');
