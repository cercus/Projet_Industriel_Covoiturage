<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
<<<<<<< HEAD
use Illuminate\Support\Facades\DB;


class UsertTest extends TestCase
{
    public function setUp(): void{
        parent::setUp();

    }


=======
use App\Repositories\Repository;
use Illuminate\Support\Facades\DB;

class UserTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp();
        $this->repository = new Repository();

    }
>>>>>>> 58a4eba1fe94a1867affb6d9176e1470ef6d390d
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

<<<<<<< HEAD
    public function test_get_user(){
        if(DB::connection()->getDatabaseName()){
            echo "yes " . DB::connection()->getDatabaseName();
        }
        //echo DB::table('Messages')->get()->first();
        echo json_encode(DB::table('Messages')->get()->toArray());
    }
=======
    /*
    public function test_get_user(){
        //var_dump($this->repository->testGetUser());
        if(DB::connection()->getDatabaseName()){
            echo "Yes! successfully connected to the DB: " . DB::connection()->getDatabaseName();
            
        }
        echo json_encode(DB::table('Messages')->where('idMessage', 1)->get()->toArray());
    }
    */
>>>>>>> 58a4eba1fe94a1867affb6d9176e1470ef6d390d
}
