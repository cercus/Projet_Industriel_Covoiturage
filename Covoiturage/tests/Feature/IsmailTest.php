<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Repositories\IsmailRepository;

class IsmailTest extends TestCase {

    public function setUp(): void
    {
        parent::setUp();
        $this->ismailRepository = new IsmailRepository();

    }

    public function testGetUser()
    {
        echo json_encode($this->ismailRepository->testRequete());
    
    }
}