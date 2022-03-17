<?php

namespace App\Http\Controllers;

use Exception;
use App\Repositories\NicolasRepository;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;


class NicolasController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct(NicolasRepository $repository) {
        $this->NicolasRepository=$repository;
    }

    public function inscriptionForm(Request $request)
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
            'telephone.min' => "Le nombre de chiffre de votre numéro de téléphone n'est pas suffisant.",
            'telephone.max' => "Le nombre de chiffre de votre numéro de téléphone est trop important.",
            'telephone.regex' => "Ce numéro de téléphone n'est pas valide.",
            'telephone.unique' => "Ce numéro de téléphone existe déjà",
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
                $idUser= $this->NicolasRepository->addUser($user);

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

                    $this->NicolasRepository->addCar($voiture);
                }
            } catch (Exception $e) {
                return redirect()->back()->withInput()->withErrors("Impossible de vous authentifier.".$e->getMessage(). "->".$e->getLine(). "->".$e->getFile());
            }
        return redirect()->route('connexion');
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
            $user = $this->NicolasRepository->getUser($email, $password);
            Request()->session()->put('user',$user);

            return redirect()->Route('user', ['idUtilisateur'=>$user['id']]);
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withErrors("Impossible de vous authentifier.".$e->getMessage());
        }
     }
    
    public function logout(Request $request) {
        $request->session()->forget('user'); 
        return redirect()->route('home');
    }
    
}