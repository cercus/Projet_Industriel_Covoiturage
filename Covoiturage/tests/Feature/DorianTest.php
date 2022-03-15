<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Repositories\DorianRepository;
use Exception;
use Illuminate\Support\Facades\DB;

class DorianTest extends TestCase {

    public function setUp(): void
    {
        parent::setUp();
        $this->dorianRepository = new DorianRepository();

    }

    
    // /* Test pour vérifier que l'user avec id 1 a bien la plaque d'imatriculation 123PLA01 */
    // public function test_get_immatriculation()
    // {
    //     $immatriculation = ['immatriculation' => "123PLA01"];
    //     $this->assertEquals($this->dorianRepository->getImmatriculationOfUser(1), $immatriculation);
    
    // }

    // /* Test pour vérifier si une exception est levé si un user n'a pas de voiture */
    // public function test_get_immatriculation_throws_exception_if_user_not_exists() {
    //     $this->expectException((Exception::class));
    //     $this->expectExceptionMessage("Utilisateur inconnu.");
    //     $this->dorianRepository->getImmatriculationOfUser(50);
    // }

    // /* test pour vérifier qu'un trajet se met bien dans la BDD */
    // /*
    // public function test_insert_trajet_in_database(){
    //     $trajet = [
    //         "numRueDep" => 78,
    //         "rueDep" => "Avenue Marechal",
    //         "villeDep" => "Marseille",
    //         "cpDep" =>13050, 
    //         "numRueArr" => 47,
    //         "rueArr" => "Rue des Halles",
    //         "villeArr" => "Marseille",
    //         "cpArr" => 13010,
    //         "dateDepart" => "2022-03-05 15:00",
    //         "nbPlace" => 1,
    //         "prix" => 4
    //     ];

    //     $this->assertEquals($this->dorianRepository->insertTrajet($trajet), 26);
    // }
    // */
    

    // public function test_get_notation_for_one_user(){
    //     $note = $this->dorianRepository->getNotationForOneUser(1, "ISMAIL", "IDBOURHIM");
    //     $this->assertEquals($note, 4);
    // }

    
    // public function test_get_trajets_conducteurs(){
    //     $trajet = [
    //         "date" => "2022-02-21",
    //         "conducteur" => "NICOLAS DUFOUR",
    //         "passager" => "ISMAIL IDBOURHIM",
    //         "adresseDepart" =>  "4 Bd de Noailles Marseille 13013",
    //         "heureDepart" => "07:00:00",
    //         "adresseArrivee" => " université Luminy marseille 13009",
    //         "heureArrivee" => "07:24:00",
    //         "idTrajet" => 1,
    //         "idPassager" => 104,
    //         "idReservation" => 1,
    //         "notation" => 4,
    //         "idConducteur" => 101
    //     ];
    //     $this->assertEquals($this->dorianRepository->getAllTrajetsConducteur(101)[0], $trajet);
    
    // }

    
    // public function test_get_trajets_passager(){
    //     $trajet = [
    //         "date" => "2022-03-05",
    //         "conducteur" => "FAUSTIN VAST",
    //         "passager" => "NICOLAS DUFOUR",
    //         "adresseDepart" => " université Luminy marseille 13009",
    //         "heureDepart" => "17:00:00",
    //         "adresseArrivee" => "42 Rue d Aubagne Marseille 13001",
    //         "heureArrivee" => "18:00:00",
    //         "idTrajet" => 18,
    //         "idPassager" => 101,
    //         "idReservation" => 25,
    //         "notation" => -4,
    //         "idConducteur" => 101
    //     ];
    //     $this->assertEquals($this->dorianRepository->getAllTrajetsPassager(101)[0], $trajet);

    //     //$this->dorianRepository->getAllTrajetsPassager(101);
    // }

    // public function test_get_info_voiture(){
    //     $voiture = [
    //         "immatriculation" => "AB100AA",
    //         "marqueModelVoiture" => "PEUGEOT 208",
    //         "photoVoiture" => NULL,
    //         "nbPlaceMax" => 4,
    //         "couleurVoiture" => "vert",
    //         "autoriserAnimal" => 1,
    //         "autoriserFumer" => 1,
    //     ];

    //     $this->assertEquals($this->dorianRepository->getCaracteristiquesVoiture(101), $voiture);
    // }

    // public function test_get_info_voiture_if_null() {

    //     $this->assertNull($this->dorianRepository->getCaracteristiquesVoiture(104));
    // }


    // public function test_modify() {
    //     $res = DB::table("Utilisateurs")->where("idUtilisateur", 1)->update(['numTelUtilisateur' =>"0545477889"]);
    // }

    public function testNotation() {
        $test = $this->dorianRepository->getTrajetFromIdReservation(25);
    }

    public function test_lieu_deja_entree(){
        $this->assertEquals($this->dorianRepository->lieuDejaEntree(170, "Avenue de Luminy", 13009, "Marseille"), 26);
    }
    
}