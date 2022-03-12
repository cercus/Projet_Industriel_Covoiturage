<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;


class UsertTest extends TestCase
{
    public function setUp(): void{
        parent::setUp();

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

    public function test_get_user(){
        if(DB::connection()->getDatabaseName()){
            echo "yes " . DB::connection()->getDatabaseName();
        }
        //echo DB::table('Messages')->get()->first();
        echo json_encode(DB::table('Messages')->get()->toArray());
    }
}
