<?php

namespace Tests\Unit;

use Exception;
use Illuminate\Support\Facades\DB;
use App\Repositories\NicolasRepository;
use GuzzleHttp\Psr7\Request;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NicolasTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->NicolasRepository = new NicolasRepository();
    }

    function testGetUserThrowsExceptionIfEmailNotExists(): void 
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Cet utilisateur n'existe pas.");
        $this->NicolasRepository->getUser('mauvais_mail@gmail.com', 'mdp');
    }

    function testGetUserThrowsExceptionIfPasswordIsAbscent(): void 
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Ce compte n'existe pas. Vérifier votre mail et votre mot de passe.");
        $this->NicolasRepository->getUser('n.dufthir@gmail.com', '');
    }

    function testGetUserThrowsExceptionIfPasswordIsIncorrect(): void 
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Ce compte n'existe pas. Vérifier votre mail et votre mot de passe.");
        $this->NicolasRepository->getUser('n.dufthir@gmail.com', 'mdp');
    }

    function testGetUserThrowsExceptionIfPasswordIsCorrect(Request $request): void 
    {
        $this->assertEquals($this->NicolasRepository->getUser('n.dufthir@gmail.com', '101Nicolas.Dufour'), ['n.dufthir@gmail.com',"Hash::make('101Nicolas.Dufour')",'101']);
    }
}