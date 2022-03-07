<?php

namespace Tests\Unit;

use PDO;
use Exception;
use Illuminate\Support\Facades\DB;
use IlluminateSupportCarbon;
use Tests\TestCase;
use App\Repositories\SawdaRepository;

class SawdaRepositoryTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->repository = new SawdaRepository();
    }

    /*function testTrajetsProposes(): void
    {
        //var_dump($this->repository->trajetsProposes($tableau));
        
    }*/

    function testUnTrajet(): void
    {
        $trajet=[
            "idTrajet"=>1,
            "dateHeureDepart"=> "2022-02-21 07:00:00",
            "nbPlace"=>4,
            "dateHeureArrivee"=>"2022-02-21 07:24:00",
            "prixTrajet"=>1,
            "rayon"=>200,
            "idLieuDepart"=>10,
            "idLieuArrivee"=>1,
            "immatriculation"=>"AB100AA",
            "numRueDep"=>"4",
            "adresseRueDep"=>"Bd de Noailles",
            "villeDep"=>"Marseille",
            "cpDep"=>13013,
            "numRueArr"=>NULL,
            "adresseRueArr"=>"université Luminy",
            "villeArr"=>"marseille",
            "cpArr"=>13009
        ];
        //var_dump($this->repository->unTrajet(1));
        $this->assertEquals($this->repository->unTrajet(1), $trajet);
    }

    function testUnProfil(): void
    {
        $unProfil= [
            "idUtilisateur"=>101,
            "prenom"=>"NICOLAS",
            "nom"=>"DUFOUR",
            "animal"=>1,
            "fumer"=>1
        ];
        //var_dump($this->repository->unProfil(1));
        $this->assertEquals($this->repository->unProfil(1), $unProfil);
    }

    function testUneNote(): void
    {
        $uneNote= [
            "notation"=>"4.6667"
        ];
        //var_dump($this->repository->uneNote(101));
        $this->assertEquals($this->repository->uneNote(101), $uneNote);
    }

    /*function testBestTrajets(): void
    {
        //var_dump($this->repository->bestTrajets());

    }*/

    function testPassagers(): void
    {
        $passagers=[
            [
              "prenom"=>"AYSEL",
              "nom"=>"LEBIGRE"
            ],
            [
              "prenom"=>"PAULINO",
              "nom"=>"CHAOUAT"
            ]
        ];
        //var_dump($this->repository->passagers(11));
        $this->assertEquals($this->repository->passagers(11), $passagers);
    }


}