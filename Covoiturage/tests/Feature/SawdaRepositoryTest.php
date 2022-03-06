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

    function testTrajetsProposes(): void
    {
        $tableau= [
            'dateDep' => '2022-02-21 07:00:00',
            'numRueDep' => 'rue',
            'adresseRueDep' => 'rue',
            'villeDep' => 'Marseille',
            'cpDep' => 13013,
            'nbPlace' => 3,
            'numRueArr' => 3,
            'adresseRueArr' => 'rue',
            'villeArr' => 'Marseille',
            'cpArr' => 13009
        ];
        //var_dump($this->repository->trajetsProposes($tableau));
        
    }

    function testUnTrajet(): void
    {
        $trajet=[
            'idTrajet'=>1,
            'dateHeureDepart'=>'2022-02-21 07:00:00',
            'nbPlace'=>4,
            'dateHeureArrivee'=> '2022-02-21 07:24:00',
            'prixTrajet'=>1,
            'rayon'=>200,
            'idLieuDepart'=>10,
            'idLieuArrivee'=>1,
            'immatriculation'=>'AB100AA'
        ];
        //var_dump($this->repository->unTrajet(1));
    }

    function testUnProfil(): void
    {
        //var_dump($this->repository->unProfil(1));
    }

    function testUneNote(): void
    {
        //La note est un string
        //var_dump($this->repository->uneNote(101));
    }

    function testBestTrajets(): void
    {
        //var_dump($this->repository->bestTrajets());

    }

    function testPassagers(): void
    {
        //var_dump($this->repository->passagers(11));
    }


}