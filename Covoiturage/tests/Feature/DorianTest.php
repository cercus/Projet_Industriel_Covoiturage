<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Repositories\Repository;
use Exception;
use Illuminate\Support\Facades\DB;

class DorianTest extends TestCase {

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = new Repository();

    }

    public function test_lieu_deja_entre() {
        $this->assertEquals($this->repository->lieuDejaEntree(170, "Avenue de Luminy", 13009, "Marseille"), 26);
    }

    public function test_lieu_pas_entre(){
        $this->assertEquals($this->repository->lieuDejaEntree(78, "Rue de Noailles", 13007, "Marseille"), -4);
        
    }

    public function test_get_immatriculation_of_user() {
        $this->assertEquals($this->repository->getImmatriculationOfUser(101), "AB100AA");
    }

    public function test_get_immatriculation_of_user_throw_exception(){
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Utilisateur inconnu.");
        $this->repository->getImmatriculationOfUser(104);

    }

    public function test_get_all_trajet_conducteur() {
        $res = $this->repository->getAllTrajetsConducteur(101);
        var_dump($res);
    }

    public function test_get_all_trajet_passager() {
        $trajet = [[
            "dateHeureRDV" => "2022-03-06 16:40:58", 
            "adresseDepart" => "47 Rue des Halles 13010 Marseille",
            "dateHeureArrivee" => "2022-03-05 18:00:00",
            "adresseArrivee" => "170 Avenue de Luminy 13009 Marseille",
            "nbPlace" => 1,
            "prixResa" => "2.10",
            "passager" => "NICOLAS DUFOUR",
            "conducteur" => "FAUSTIN VAST",
            "idConducteur" => 1,
            "idPassager" => 101,
            "idReservation" => 25,
            "note" => 4
        ]];
        //var_dump($this->repository->getAllTrajetsPassager(101));
        $this->assertEquals($this->repository->getAllTrajetsPassager(101), $trajet);
        
    }

}