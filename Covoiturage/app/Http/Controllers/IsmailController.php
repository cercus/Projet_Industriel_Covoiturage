<?php

namespace App\Http\Controllers;

use DateTime;
use Exception;
use App\Repositories\IsmailRepository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;

class IsmailController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(IsmailRepository $repository)
    {
        $this->repository = $repository;
    }

/*---------------------------------page informations personnelles----------------------------*/

    public function showInfosPerso($idUtilisateur){
        if(!session()->has('user'))
            return redirect()->route('home');
        if(session()->get('user')['id'] != $idUtilisateur)
            return redirect()->route('home');
        $infoPerso = $this->repository->infoPersonnelles($idUtilisateur);
        $nbrTrajetPassager = $this->repository->nbrTrajetPassager($idUtilisateur);
        $nbrTrajetConducteur = $this->repository->nbrTrajetConducteur($idUtilisateur);
        $estConducteur = $this->repository->estConducteur($idUtilisateur);
        if ($estConducteur == false) {
            return view('commun.informations_personnelles', 
                ['infoPerso' => $infoPerso[0], 
                 'nbrTrajetPassager' => $nbrTrajetPassager,
                 'nbrTrajetConducteur' => $nbrTrajetConducteur,
                 'estConducteur' => $estConducteur]);
                 
        }
        else {
            $infoTechnique = $this->repository->infoTechniques($idUtilisateur);
            return view('commun.informations_personnelles', 
                ['infoPerso' => $infoPerso[0], 
                 'nbrTrajetPassager' => $nbrTrajetPassager,
                 'nbrTrajetConducteur' => $nbrTrajetConducteur,
                 'infoTechnique' => $infoTechnique[0],
                 'estConducteur' => $estConducteur]);
        }
        
    }

/*---------------------------------page modification profil----------------------------*/

    public function showModificationProfilForm($idUtilisateur) 
    {
        if(!session()->has('user'))
            return redirect()->route('home');
        if(session()->get('user')['id'] != $idUtilisateur)
            return redirect()->route('home');
        $infoPerso = $this->repository->infoPersonnelles($idUtilisateur);
        return view('commun.modification_profil', ['infoPerso' => $infoPerso[0]]);
    }

    // Bouton modifier info personnelles
    public function modifyProfil(Request $request) 
    {
        if(!session()->has('user'))
            return redirect()->route('home');
        $idUtilisateur = $request->session()->get('user')['id'];
        $messages = [
            'nom.required' => 'vous devez saisir votre nom',
            'prenom.required' => 'vous devez saisir votre prenom',
            'email.required' => 'Vous devez saisir un e-mail.',
            'email.email' => 'Vous devez saisir un e-mail valide.',
            'email.exists' => "Ce mail existe déjà.",
            'tel.required' => "Vous devez indiquer votre numero de téléphone.",
            'tel.min' => "Le nombre de chiffre de votre numéro de téléphone n'est pas suffisant.",
            'tel.max' => "Le nombre de chiffre de votre numéro de téléphone est trop important.",
            'tel.regex' => "Ce numéro de téléphone n'est pas valide.",
            'dateNaiss.before' => "Votre age ne permet pas de vous inscrire",
            'dateNaiss.after_or_equal' => "Votre age ne permet pas de vous inscrire",
            'dateNaiss.required' => "Vous devez saisir votre date de naissance",
            'nni.required' => "Vous devez saisir votre numero d'identité.",
            'numPermis.required' => 'Vous devez saisir votre numéro du permis.'
        ];
        $rules = [
            'nom' => ['required'],
            'prenom' => ['required'],
            'email' => ['required' , 'email:rfc,dns','exists:Utilisateurs,emailUtilisateur'],
            'tel' => ['required','regex:/^([0-9\s\-\+\(\)]*)$/','min:10','max:20'],
            'dateNaiss'=> 'required|after_or_equal:'.now()->subYears(100),'before:'.now()->subYears(18),
            'nni' => ['required'],
            'numPermis' => ['required']
        ];
        $validatedData = $request->validate($rules, $messages);
        try{
            
            DB::table('Utilisateurs')->where('idUtilisateur', $idUtilisateur)
                                    ->update(['prenomUtilisateur' => $request->input('prenom'),
                                            'nomUtilisateur' => $request->input('nom'),
                                            'emailUtilisateur' => $request->input('email'),
                                            'photoProfil' => $request->input('profil'),
                                            'numTelUtilisateur' => $request->input('tel'),
                                            'dateNaiss' => $request->input('dateNaiss'),
                                            'descriptionUtilisateur' => $request->input('description'),
                                            'numPermisConduire' => $request->input('numPermis'),
                                            'numeroIdentite' => $request->input('nni')
                                            ]);
            return redirect()->route('informations_personnelles', ['idUtilisateur' => $idUtilisateur])
                             ->withSuccess('Vos informations personnelles ont été modifiées avec succès.');
        } catch (Exception $exception) {
            return redirect()->route('modification_profil', ['idUtilisateur' => $idUtilisateur])
                    ->withInput()
                    ->withErrors("votre profil n'a pas été modifié.");
        }
    }
    
/*---------------------------------page modification technique----------------------------*/

    // Page modification technique
    public function showModificationTechniqueForm($idUtilisateur) 
    {
        if(!session()->has('user'))
            return redirect()->route('home');
        if(session()->get('user')['id'] != $idUtilisateur)
            return redirect()->route('home');
        $infoPerso = $this->repository->infoPersonnelles($idUtilisateur);
        $infoTechno = $this->repository->infoTechniques($idUtilisateur);
        return view('commun.modification_technique', ['infoTechno' => $infoTechno[0], 
                                                      'infoPerso' => $infoPerso[0]]);
    }    

    // Bouton modifier info technique
    public function modifyTechnique(Request $request) 
    {
        if(!session()->has('user'))
            return redirect()->route('home');
        $idUtilisateur = $request->session()->get('user')['id'];
        $messages = ['marque.required' => "vous devez saisir la marque de votre voiture.",
                     'couleur.required' => "Vous devez saisir la couleur de votre voiture.",
                     'nbPlace.max'=> "Le nombre de place maximum est de 9.",
                     'nbPlace.required' => "Vous devez saisir un nombre de places.",
                     'immatriculation.required' => "Vous avez dépassé le nombre maximal (9)."
        ];
        $rules = ['marque' => ['required'],
                  'couleur' => ['required'],
                  'nbPlace'=> ['required', 'max:9'],
                  'immatriculation' => ['required']
        ];
        $validatedData = $request->validate($rules, $messages);
        try{
            DB::table('Voitures')->where('idUtilisateur', $idUtilisateur)
                                ->update(['immatriculation' => $request->input('immatriculation'),
                                        'marqueModelVoiture' => $request->input('marque'),
                                        'photoVoiture' => $request->input('photoVoiture'),
                                        'nbPlaceMax' => $request->input('nbPlace'),
                                        'couleurVoiture' => $request->input('couleur'),
                                        'autoriserAnimal' => $request->input('animaux'),
                                        'autoriserFumer' => $request->input('fumer')
                                        ]);
            return redirect()->route('informations_personnelles', ['idUtilisateur' => $idUtilisateur])
                             ->withSuccess('Vos informations techniques ont été modifiées avec succès.');
        }catch(Exception $exception){
            return redirect()->route('modification_technique', ['idUtilisateur' => $idUtilisateur])
                    ->withInput()
                    ->withErrors("votre profil n'a pas été modifié.");
        }   
    }

    /*-----------------------Méthodes pour la page mes trajets en cours-------------------*/

    public function showTrajetEnCours($idConducteur)
    {
        if(!session()->has('user'))
            return redirect()->route('home');
        if(session()->get('user')['id'] != $idConducteur)
            return redirect()->route('home');
        $trajetsEnCours = $this->repository->trajetEnCours($idConducteur);
        $tailleTableau = count($trajetsEnCours);
        $tabletime = [];
        $tabDateFrenche =[];
        //tableau pour récupérer les passagers d'un trajet
        $passagers = [];
        for ($i=0; $i < $tailleTableau ; $i++) {
            //pour calucler le temps d'un trajet
            $date1 = new DateTime($trajetsEnCours[$i]->dateHeureDepart);
            $date2 = new DateTime($trajetsEnCours[$i]->dateHeureArrivee);
            $differenceHours = $date1->diff($date2)->h;
            $differenceMinutes = $date1->diff($date2)->i;
            $timeTrajet = $differenceMinutes + ($differenceHours*60);
            $tableTime[$i]= $timeTrajet;
            //pour traduire la date en francais
            setlocale(LC_TIME, 'french');
            $dateFrench = strftime("%a %d/%m", strtotime($trajetsEnCours[$i]->dateHeureDepart));
            $tabDateFrenche[$i] = $dateFrench;
            //pour récupérer les passagers d'un trajet
            $passagers[$i] = $this->repository->passagersDuTrajet($trajetsEnCours[$i]->idTrajet);
        }
        return view('/conducteur/trajets_en_cours', ['trajetsEnCours' => $trajetsEnCours, 
                                                     'tableTime' => $tableTime,
                                                     'tabDateFrenche' => $tabDateFrenche,
                                                     'passagers' => $passagers
                                                     ]);
    }

    //function pour valider un passager par un conducteur
    public function validerPassager(Request $request, $idReservation)
    {
        if(!session()->has('user'))
            return redirect()->route('home');
        $idConducteur = $request->session()->get('user')['id'];
        $nbrPlacesMax = $this->repository->nbrPlacesMax($request->idTrajet);
        $nbrPassagerAcceptes = $this->repository->nbrPassagerAcceptes($request->idTrajet);
        //pour ne pas dépassé nombre de places max autorisées
        if($nbrPlacesMax >= ($nbrPassagerAcceptes * $request->nbrplaces)) {
            DB::table('Reservations')->where('idReservation', $idReservation)->update(['estAccepte' => 1]);
            $this->repository->AvertirAcceptationPassager($idConducteur, $request->idPassager);
            return redirect()->back();
        }
        return redirect()->back()->with('errors', 'Vous avez dépassé le nombre maximum de places autorisées.');          
    }

    //function pour refuser un passager par un conducteur
    public function refuserPassager(Request $request, $idReservation)
    {
        if(!session()->has('user'))
            return redirect()->route('home');
        $idConducteur = $request->session()->get('user')['id'];
        $this->repository->AvertirRejetPassager($idConducteur, $request->idPassager);
        DB::table('Reservations')->where('idReservation', $idReservation)->delete();
        return redirect()->back();
    }
    
    /*-----------------------Méthodes pour la page annuler mon trajet-------------------*/
    
    public function showAnnulerTrajet($idTrajet) 
    {   
        if(!session()->has('user'))
            return redirect()->route('home');
        $idConducteur = Request()->session()->get('user')['id'];
        return view('/conducteur/annuler_trajet', ['idConducteur' => $idConducteur, 'idTrajet' => $idTrajet]);
    }
    
    public function acceptAnnulerTrajet(Request $request, $idTrajet)
    {   
        if(!session()->has('user'))
            return redirect()->route('home');
        $idConducteur = Request()->session()->get('user')['id'];
        $passagers = $this->repository->passagersDuTrajet($idTrajet);
        $rules = ['motif-annulation' => ['required']];
        $messages = ['motif-annulation.required' => "Vous devez saisir le motif d'annulation"];
        $validatedData = $request->validate($rules, $messages);
        $motif = $request->input('motif-annulation');
        $message = $request->input('message-conducteur');
        if ($message == null)
            $texteMessage = "Nous avons le regret de vous informer que le conducteur a récemment annulé le trajet que vous avez réservé sans vous laisser de message en raison de : \n$motif";
        else
            $texteMessage = "Motif : $motif \nMessage du conducteur : $message";
        foreach ($passagers as $passager) {
            DB::table('Messages')->insertGetId(['objet' => 'Annulation du trajet',
                                        'dateMessage' => NOW(),
                                        'texteMessage' => $text,
                                        'idEmetteur' => $idConducteur,
                                        'idDestinataire' => $passager->idPassager]);
        }
        DB::table('Trajets')->where('idTrajet', $idTrajet)->delete();
        return redirect()->route('confirmation_annuler_trajets');        
    }

/*-----------------------Méthodes pour la page confirmation d'annulation de mon trajet-------------------*/

    public function showConfirmAnnulationTrajet() 
    {
        if(!session()->has('user'))
            return redirect()->route('home');
        $idConducteur = Request()->session()->get('user')['id'];
        return view('conducteur.confirmation_annuler_trajets', ['idConducteur' => $idConducteur]);
    }
}
