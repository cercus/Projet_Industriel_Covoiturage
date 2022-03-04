<?php

namespace App\Repositories;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\isNull;

class Repository {
    function testGetUser() : array{
        return DB::table('Utilisateurs')->get()->toArray();
    }
}