<?php

use App\Http\Controllers\LocalizationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DorianController;
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

Route::get('/', [Controller::class, 'showHome'])->name('home');
// Route qui permet de connaître la langue active
Route::get('locale', [LocalizationController::class, 'getLang'])->name('getlang');

// Route qui permet de modifier la langue
Route::get('locale/{lang}', [LocalizationController::class, 'setLang'])->name('setlang');

// Route test lang
Route::get('/testLang',function () {
    return view('testLang');
});


/* ------------ Route pour les pages se trouvant dans le dossier commun ------------ */

//Route pour la page de profil 
Route::get('/commun/user', [Controller::class, 'showUserPage'])->name('user');

// Route pour la page historique des trajets
Route::get('/commun/historique_trajets/{idUtilisateur}', [DorianController::class, 'showHistoriqueTrajet'])->where('idUtilisateur', '[0-9]+')->name('historique_trajets');

// Route pour la page de modification du profil
Route::get('/commun/modification_profil', [Controller::class, 'showModificationProfilForm'])->name('modification_profil');
Route::post('/commun/modification_profil', [Controller::class, 'modifyProfil'])->name('modify.profil');

// Route pour la page Mes messages
Route::get('/commun/mes_messages', [Controller::class, 'showMesMessages'])->name('messages.all');
Route::post('/commun/mes_messages', [Controller::class, 'newMessage'])->name('message.new');

// Route pour la page information personnels
Route::get('/commun/informations_personnelles', [Controller::class, 'showInfosPerso'])->name('informations_personnelles');
Route::post('/commun/informations_personnelles')->name('informations_personnelles_post');

// Route pour la page de modification technique
Route::get('/commun/modification_technique', [Controller::class, 'showModificationTechniqueForm'])->name('modification_technique');
Route::post('/commun/modification_technique', [Controller::class, 'modifyTechnique'])->name('modify.technique');

// Route pour la page ecrire_message.php
Route::get('/commun/nouveau_message', [Controller::class, 'showEcrireMessageForm'])->name('messages.new');

// Route pour la page repondre_message.php
Route::get('/commun/repondre_message', [Controller::class, 'showMessagesReply'])->name('messages.reply');

// Route pour la page de notation
Route::get('/commun/notation', [Controller::class, 'showNotation'])->name('notation');

// Route pour la page caractéristique d'un user
Route::get('/commun/caracteristiques', [Controller::class, 'showCaracteristique'])->name('caracteristiques');

/* ------------ Route pour les pages se trouvant dans le dossier conducteur ------------ */

// Route pour la page trajet_en_cours.php
Route::get('/conducteur/trajets_en_cours', [Controller::class, 'showTrajetEnCours'])->name('trajets_en_cours');

// Route Annuler un trajet */
Route::get('/conducteur/annuler_trajet', [Controller::class, 'showAnnulerTrajet'])->name('annuler_trajet');

// Route confirmation annulation trajet
Route::get('/conducteur/confirmation_annuler_trajets', [Controller::class, 'showConfirmAnnulationTrajet'])->name('confirmation_annuler_trajets');

// Route proposer un trajet
Route::get('/conducteur/proposer_trajet', [DorianController::class, 'showProposerTrajetForm'])->name('proposer_trajet');
Route::post('/conducteur/submit_proposer_trajet', [DorianController::class, 'storeProposerTrajetForm'])->name('store.proposer_trajet');


/* ------------ Route pour les pages se trouvant dans le dossier passager ------------ */

Route::get('/passager/reservation_en_cours', [Controller::class, 'showReservationEnCours'])->name('reservation_en_cours');

// Route Annuler une reservation */
Route::get('/passager/annuler_reservation', [Controller::class, 'showConfirmAnnulationReservation'])->name('annuler_reservation');

// Route confirmation annulation reservation
Route::get('/passager/confirmation_annuler_reservation', [Controller::class, 'showConfirmAnnulationReservation'])->name('confirmation_annuler_reservation');

// ROute payement trajet
Route::get('/passager/payement', [Controller::class, 'showPayementForm'])->name('payement');

// Route recherche de trajet
Route::get('/passager/recherche_trajet', [Controller::class, 'showRechercheTrajet'])->name('recherche_trajet');

Route::get('/passager/details_result_recherche_trajet', [Controller::class, 'showDetailRechercheTrajet'])->name('details_result_recherche_trajet');


/* ------------ Route pour les autres pages ------------ */

// Route pour la page Poser une question
Route::get('/question', [Controller::class, 'showQuestionForm'])->name('question');
Route::post('/question', [MailsController::class, 'storeQuestion'])->name('store.question');


// ROute a propos
Route::get('/apropos', [Controller::class, 'showAPropos'])->name('apropos');

// Route pour la page Inscription
Route::get('/inscription', [Controller::class, 'showInscriptionForm'])->name('inscription');

// Route pour la page de connexion
Route::get('/connexion', [Controller::class, 'showConnexionForm'])->name('connexion');
Route::post('/connexion', [Controller::class, 'storeConnexion'])->name('store.connexion');

// Route pour la page Reinitialisation mdp
Route::get('/reinitialisation_mdp', [Controller::class, 'showReinitialisationMdp'])->name('reinitialisation_mdp');

// Route pour la page Qui-sommes-nous
Route::get('qui_sommes_nous', [Controller::class, 'showQuiSommesNous'])->name('qui_sommes_nous');


#Route::get('/testAPIMap', [Controller::class, 'showAPIMap'])->name('testapimap');
#Route::post('/submit-testAPIMap', [DorianController::class, 'storeTestAjax'])->name('store.testapimap');