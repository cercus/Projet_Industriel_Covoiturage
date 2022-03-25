<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Repositories\Repository;
use Illuminate\Support\Facades\DB;

class UserTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = new Repository();

    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /*
    public function test_get_user(){
        //var_dump($this->repository->testGetUser());
        if(DB::connection()->getDatabaseName()){
            echo "Yes! successfully connected to the DB: " . DB::connection()->getDatabaseName();
            
        }
        echo json_encode(DB::table('Messages')->where('idMessage', 1)->get()->toArray());
    }
    */
}
