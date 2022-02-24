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
// Route pour la page d'accueil
Route::get('/', function () {
    return view('home');
});
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

// Route pour la page de modification du profil
Route::get('/modification_profil', [Controller::class, 'showModificationProfilForm'])->name('modification_profil');
Route::post('/modification_profil', [Controller::class, 'modifyProfil'])->name('modify.profil');

// Route pour la page information personnels
Route::get('/informations_personnelles', [Controller::class, 'showInfosPerso'])->name('informations_personnelles');
Route::post('informations_personnelles')->name('informations_personnelles_post');

// Route pour la page de modification technique
Route::get('/modification_technique', [Controller::class, 'showModificationTechniqueForm'])->name('modification_technique');
Route::post('/modification_technique', [Controller::class, 'modifyTechnique'])->name('modify.technique');