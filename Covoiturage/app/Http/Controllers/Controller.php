<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Repositories\Repository;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(Repository $Repository) 
    {
        $this->repository  = $Repository;
    }


    /* ----------------- Fonctions pour les pages se trouvant dans le dossier commun ----------------- */

    // Page de profil (contenant tout les accès aux différents pages )
    public function showUserPage() {
        return view('commun.user');
    }

    // Page de l'historique des trajets d'un utilisateur
    public function showHistoriqueTrajet() {
        return view('commun.historique_trajets');
    }
/*
    // page modification de profil
    public function showModificationProfilForm(Request $request) {
        
        //if(!$request->session()->has('user'))
        //    return redirect()->route('connexion');
        
        return view('commun.modification_profil');
    }

    // Bouton modifier info personnelles
    public function modifyProfil() {
        //TODO 
        return view('commun.modification_profil');
    }

    // Bouton modifier info technique
    public function modifyTechnique() {
         //TODO
        return view('commun.modification_technique');
    }

    // Page modification technique
    public function showModificationTechniqueForm() {
        return view('commun.modification_technique');
    }

    // Page Informations personnelles
    public function showInfosPerso(){
        return view('commun.informations_personnelles');
    }
*/
    // Page Mes messages
    public function showMesMessages() {
        return view('commun.mes_messages');
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

    // public function showConfirmAnnulationTrajet() {
    //     return view('conducteur.confirmation_annuler_trajets');
    // }

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

    /* ====== Page d'inscription ====== */

    public function showInscriptionForm() {
        if(session()->has('user'))
            return redirect()->route('home');
        return view('inscription');
    }

    public function storeInscription(Request $request)
    {
        //var_dump('dateNaiss');
        $rules = [
            'nom' => ['required'],
            'prenom' => ['required'],
            'email' => ['required' , 'email:rfc,dns'],//'unique:Utilisateurs,emailUtilisateur'],
            'telephone' => ['required'],//'unique:Utilisateurs,numTelUtilisateur', 'regex:/^([0-9\s\-\+\(\)]*)$/','min:10','max:20'],
            'mdp' => ['required',Password::min(8)->mixedCase()->letters()->numbers()->symbols()->uncompromised()],
            'repeterMdp' =>'required|min:8|same:mdp',
            'dateNaiss'=> 'required|after_or_equal:'.now()->subYears(100),'before:'.now()->subYears(18),
            'immatriculation'=>['nullable'],
            'marqueVoiture'=>['nullable'],
            'nbPlace'=>['nullable','max:9'],
            'couleurVoiture'=>['nullable'],
            'profil'=>['nullable'],
            'photoVoiture'=>['nullable'],
            'description'=>['nullable'],
            'nni' => ['nullable'],
            'numPermis' => ['nullable'],
            'nni' => ['nullable'],
            'numPermis' => ['nullable'],
            'animaux' =>['nullable'],
            'fumer' =>['nullable']
        ];
        $messages = [
            'nom.required' => 'vous devez saisir votre nom',
            'prenom.required' => 'vous devez saisir votre prenom',
            'email.required' => 'Vous devez saisir un e-mail.',
            'email.email' => 'Vous devez saisir un e-mail valide.',
            'email.exists' => "Ce mail existe déjà.",
            'telephone.required' => "Vous devez indiquer votre numero de téléphone.",
            // 'telephone.min' => "Le nombre de chiffre de votre numéro de téléphone n'est pas suffisant.",
            // 'telephone.max' => "Le nombre de chiffre de votre numéro de téléphone est trop important.",
            // 'telephone.regex' => "Ce numéro de téléphone n'est pas valide.",
            // 'telephone.unique' => "Ce numéro de téléphone existe déjà",
            'mdp.required' => "Vous devez saisir un mot de passe.",
            'mdp.min' => "vous devez mettre au moins 8 caractères",
            'mdp.letters' => "vous devez mettre au moins deux lettres, une majuscule et une minuscule",
            'mdp.mixedCase' => "vous devez mettre au moins deux lettres, une majuscule et une minuscule",
            'mdp.numbers' => "vous devez mettre au moins un chiffre",
            'mdp.symbols' => "vous devez mettre dau moins un caractères spéciale.",
            'mdp.uncompromised' => "votre mot de passe est consideré comme corrompu, merci de le modifier.",
            'dateNaiss.before' => "Votre age ne permet pas de vous inscrire",
            'dateNaiss.after_or_equal' => "Votre age ne permet pas de vous inscrire",
            'dateNaiss.required' => "Vous devez saisir votre date de naissance",
            'repeterMdp.same'=> "Les deux mots de passe de correspondent pas",
            'nbPlace.max'=>'Le nombre de place maximum est de 9',
            'nni.required' => "Vous devez saisir votre numero d'identité.",
            'numPermis.required' => 'Vous devez saisir votre numéro du permis.'
        ];
        $validatedData = $request->validate($rules, $messages);

        $prenom=$validatedData['prenom'];
        $nom=$validatedData['nom'];
        $email= $validatedData['email'];
        $telephone=$validatedData['telephone'];
        $password= $validatedData['mdp'];
        $passwordHash= Hash::make($password);
        $dateNaiss= $validatedData['dateNaiss'];
        $immatriculation=$validatedData['immatriculation'];
        $marqueVoiture=$validatedData['marqueVoiture'];
        $nbPlace=$validatedData['nbPlace'];
        $couleurVoiture=$validatedData['couleurVoiture'];
        $photoProfil=$validatedData['profil'];
        $photoVoiture=$validatedData['photoVoiture'];
        $description=$validatedData['description'];
        $autoriserAnimal=$validatedData['animaux'];
        $autoriserFumer=$validatedData['fumer'];
        $numPermis=$validatedData['numPermis'];
        $nni=$validatedData['nni'];

        if ($autoriserAnimal=='oui')
            $autoriserAnimal=1;
        else
            $autoriserAnimal=0;

        if ($autoriserFumer=='oui')
            $autoriserFumer=1;
        else
            $autoriserFumer=0;

            try {
                $user =["prenomUtilisateur"=> $prenom,
                        "nomUtilisateur" => $nom,
                        "emailUtilisateur" =>  $email,
                        "photoProfil" =>  $photoProfil,
                        "password" => $passwordHash,
                        "numTelUtilisateur" => $telephone,
                        "dateNaiss" => $dateNaiss,
                        "descriptionUtilisateur" => $description,
                        "numPermisConduire" => $numPermis,
                        "numeroIdentite" => $nni
                ];
                $idUser= $this->repository->addUser($user);

                if (!empty($immatriculation))
                {
                    $request->validate($rules, $messages);
                    $voiture=["immatriculation"=> $immatriculation,
                            "marqueModelVoiture"=> $marqueVoiture,
                            "photoVoiture"=> $photoVoiture,
                            "nbPlaceMax"=> $nbPlace,
                            "couleurVoiture"=> $couleurVoiture,
                            "autoriserAnimal"=> $autoriserAnimal,
                            "autoriserFumer"=> $autoriserFumer,
                            "idUtilisateur"=> $idUser
                    ];

                    $this->repository->addCar($voiture);
                }
            } catch (Exception $e) {
                return redirect()->back()->withInput()->withErrors("Impossible de vous authentifier.".$e->getMessage(). "->".$e->getLine(). "->".$e->getFile());
            }
        return redirect()->route('connexion');
    }

    // FOnction pour afficher la page de connexion
    /* ====== Page de connexion ====== */
    // FOnction pour afficher la page de connexion
    public function showConnexionForm() {
        if(session()->has('user'))
            return redirect()->route('home');
        return view('connexion');
    }

    public function Connexion()
    {
        $rules = [
            'email' => ['required', 'email', 'exists:Utilisateurs,emailUtilisateur'],
            'password' => ['required']
        ];
        $messages = [
            'email.required' => 'Vous devez saisir un e-mail.',
            'email.email' => 'Vous devez saisir un e-mail valide.',
            'email.exists' => "Cet utilisateur n'existe pas.",
            'password.required' => "Vous devez saisir un mot de passe.",
        ];
        $validatedData = Request()->validate($rules, $messages);
        try {
            # lever exception si password incorrect et se souvenir de l'authentification
            $email= $validatedData['email'];
            $password= $validatedData['password'];
            $user = $this->repository->getUser($email, $password);
            Request()->session()->put('user',$user);

            return redirect()->route('home');
            //return redirect()->Route('user', ['idUtilisateur'=>$user['id']]);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors("Impossible de vous authentifier.".$e->getMessage());
        }
    }

    public function logout(Request $request) {
        $request->session()->forget('user'); 
        return redirect()->route('home');
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
