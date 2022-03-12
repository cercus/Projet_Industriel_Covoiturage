<?php

namespace Tests\Unit;

use Exception;
use Illuminate\Support\Facades\DB;
use App\Repositories\NicolasRepository;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;


class NicolasTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        $this->NicolasRepository = new NicolasRepository();
    }
    function testAddUserForInscription():void
    {
        $this->NicolasRepository->addUser(["prenomUtilisateur"=> 'FAUSTIN1',"nomUtilisateur" => 'VAST1', "emailUtilisateur" =>'faustin1.vast1@gmail.com', "password" =>'1VF1', "numTelUtilisateur" =>'0699699891', "dateNaiss" =>'1968-11-01', "numPermisConduire" => '681113699891', "numeroIdentite" =>'749479388321']);
    }

    function testGetUserThrowsExceptionIfEmailNotExists(): void 
    {
        $this->NicolasRepository->addUser(['mauvais_mail@gmail.com', 'mdp']);
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Utilisateur inconnu');
        $this->NicolasRepository->getUser('mauvais_mail1@.com', 'mdp');
    }

    function testGetUserThrowsExceptionIfPasswordIsIncorrect(): void 
    {
        $this->NicolasRepository->addUser(['mauvais_mail@gmail.com', 'mdp']);
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Utilisateur inconnu');
        $this->NicolasRepository->getUser('mauvais_mail@gmail.com', 'mdp1');
    }

    function testAddUserThrowsExceptionIfEmailAlreadyExists(): void
    {
        $this->NicolasRepository->addUser(['faustin.vast@gmail.com', 'mdp']);
        $this->expectException(Exception::class);
        $this->NicolasRepository->addUser(['faustin.vast@gmail.com', 'mdp1']);
        
    }

    function testChangePassword(): void 
    {
        $this->NicolasRepository->addUser(['faustin.vast@gmail.com', 'mdp']);
        $this->NicolasRepository->changePassword('faustin.vast@gmail.com', 'mdp', 'mdp1');
        $user = $this->NicolasRepository->getUser('faustin.vast@gmail.com', 'mdp1');
        $this->assertEquals($user, ['id'=>1, 'email'=> 'faustin.vast@gmail.com']);
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Utilisateur inconnu');
        $user = $this->NicolasRepository->getUser('faustin.vast@gmail.com', 'mdp');
    }

    function testChangePasswordThrowsExceptionIfOldPasswordIsIncorrect(): void {
        $this->NicolasRepository->addUser(['faustin.vast@gmail.com', 'mdp']);
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Utilisateur inconnu');
        $this->NicolasRepository->changePassword('faustin.vast@gmail.com', 'mdp1', 'mdp');
    }
}