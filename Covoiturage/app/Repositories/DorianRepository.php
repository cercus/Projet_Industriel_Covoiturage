<?php

namespace App\Repositories;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use function PHPUnit\Framework\isNull;

class DorianRepository {

    function testRequete() {
        return DB::table('Utilisateurs')->where('idUtilisateur', 104)->get()->toArray();
    }
}