<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Repositories\DorianRepository;

class DorianTest extends TestCase {

    public function setUp(): void
    {
        parent::setUp();
        $this->dorianRepository = new DorianRepository();

    }

    public function testGetUser()
    {
        echo json_encode($this->dorianRepository->testRequete());
    
    }
}