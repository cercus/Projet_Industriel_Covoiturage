<?php

namespace App\Repositories;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class NicolasRepository
{

    // Securisation 

    // ajouter un utilisateur
    function addUser(array $user): int
    {
        //'emailUtilisateur', 'photoProfil', 'password', 'numTelUtilisateur', 'dateNaiss', 'descriptionUtilisateur', 'numPermisConduire', 'numeroIdentite'
        var_dump($user);
        return DB::table('Utilisateurs')->insertGetId($user);

    }
    
    //vérifier le mot de passe d'un utilisateur
    function getUser(string $email, string $password): array
    {
        $user = DB::table('Utilisateurs')->where('emailUtilisateur', $email)->get()->toArray();

        if (empty($user))  // si l'utilisateur n'existe pas
            throw new Exception('Utilisateur inconnu'); 

        $user=$user[0];

        if (! Hash::check($password, $user->password)) // si le password n'est pas hashé ou que le paswoord n'est pa bon
            throw new Exception('Utilisateur inconnu'); 

        return ['idUtilisateur'=> $user->idUtilisateur,'emailUtilisateur'=> $user->email];
    }
    
    //modifierle mot de passe d'un utilisateur
    function changePassword(string $email, string $oldPassword, string $newPassword): void 
    {
        $this->getUser($email, $oldPassword); // si le compte n'existe pas ou le mot de passe n'est pas bon, il realisera une exeption
        DB::table('Utilisateurs')->where('email', $email)->update(['password_hash'=> Hash::make($newPassword)]);
    }

    // retourner l'id de l'utilisateur en donner son mail
    function getIdUserSvtEmail(String $email):array
    {
        $user = DB::table('Utilisateurs')->where('emailUtilisateur', $email)->get()->toArray();
        if (empty($user))  // si l'utilisateur n'existe pas
            throw new Exception('Utilisateur inconnu'); 
        $user = $user[0];
        return ['idUtilisateur'=> $user->idUtilisateur];
    }
    // ajouter à la base de données un véhicule
    function addCar(array $voiture): void
    {
        var_dump($voiture);
        DB::table('Voitures')->insertGetId($voiture);
    }


   
}