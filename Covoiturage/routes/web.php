<?php

use App\Http\Controllers\LocalizationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\IsmailController;
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
// Route::get('/', function () {
//     return view('home');
// });

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
Route::get('/commun/historique_trajets', [Controller::class, 'showHistoriqueTrajet'])->name('historique_trajets');

// Route pour la page de modification du profil
Route::get('/commun/modification_profil/{idUtilisateur}', [IsmailController::class, 'showModificationProfilForm'])->where('idUtilisateur', '[0-9]+')->name('modification_profil');
Route::post('/commun/modification_profil', [IsmailController::class, 'modifyProfil'])->name('modify.profil');

// Route pour la page information personnels
Route::get('/commun/informations_personnelles/{idUtilisateur}', [IsmailController::class, 'showInfosPerso'])->where('idUtilisateur', '[0-9]+')->name('informations_personnelles');
Route::post('/commun/informations_personnelles', [IsmailController::class, 'storeInfosPerso'])->name('informations_personnelles_post');

// Route pour la page Mes messages
Route::get('/commun/mes_messages', [Controller::class, 'showMesMessages'])->name('messages.all');
Route::post('/commun/mes_messages', [Controller::class, 'newMessage'])->name('message.new');

// Route pour la page de modification technique
Route::get('/commun/modification_technique/{idUtilisateur}', [IsmailController::class, 'showModificationTechniqueForm'])->where('idUtilisateur', '[0-9]+')->name('modification_technique');
Route::post('/commun/modification_technique', [IsmailController::class, 'modifyTechnique'])->name('modify.technique');

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
Route::get('/conducteur/trajets_en_cours/{idConducteur}', [IsmailController::class, 'showTrajetEnCours'])->where('idConducteur', '[0-9]+')->name('trajets_en_cours');
Route::post('/conducteur/validerPassager/{idReservation}', [IsmailController::class, 'validerPassager'])->name('validerPassager.store');
Route::post('/conducteur/refuserPassager/{idReservation}', [IsmailController::class, 'refuserPassager'])->name('refuserPassager.store');
// Route::post('/conducteur/annulerTrajet/{idTrajet}', [IsmailController::class, 'annulerTrajet'])->name('annulerTrajet.store');
// Route Annuler un trajet */
Route::get('/conducteur/annuler_trajet/{idTrajet}', [IsmailController::class, 'showAnnulerTrajet'])->where('idTrajet', '[0-9]+')->name('annuler_trajet');
Route::post('/conducteur/accAnnulerTrajet/{idTrajet}',[IsmailController::class, 'acceptAnnulerTrajet'])->where('idConducteur', '[0-9]+')->name('acceptAnnulerTrajet.store');
// Route::post('/conducteur/refusAnnulerTrajet/{idConducteur}',[IsmailController::class, 'refusAnnulerTrajet'])->name('refusAnnulerTrajet.store');

// Route confirmation annulation trajet
Route::get('/conducteur/confirmation_annuler_trajets', [IsmailController::class, 'showConfirmAnnulationTrajet'])->name('confirmation_annuler_trajets');

// Route proposer un trajet
Route::get('/conducteur/proposer_trajet', [COntroller::class, 'showProposerTrajetForm'])->name('proposer_trajet');


/* ------------ Route pour les pages se trouvant dans le dossier passager ------------ */

Route::get('/passager/reservation_en_cours/{idPassager}', [IsmailController::class, 'showReservationEnCours'])->where('idPassager', '[0-9]+')->name('reservation_en_cours');

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
Route::post('/inscription', [Controller::class, 'storeInscription'])->name('store.inscription');

// Route pour la page de connexion
Route::get('/connexion', [Controller::class, 'showConnexionForm'])->name('connexion');
Route::post('/connexion', [Controller::class, 'Connexion'])->name('store.connexion');

//Route de deconnexion
Route::post('/logout', [Controller::class, 'logout'])->name('logout.post');

// Route pour la page Reinitialisation mdp
Route::get('/reinitialisation_mdp', [Controller::class, 'showReinitialisationMdp'])->name('reinitialisation_mdp');

// Route pour la page Qui-sommes-nous
Route::get('qui_sommes_nous', [Controller::class, 'showQuiSommesNous'])->name('qui_sommes_nous');
