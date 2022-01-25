<?php

namespace App\Core;

use App\Scaffolding\Database\DB;
use App\Scaffolding\Response;

class UserController
{
    public static function getUserOverview() {
        $result = DB::table("user")
            ->select(['user.id', 'user.name', 'r.name as role'])
            ->innerJoin('role r', 'user.id_role', '=', 'r.id')
            ->get();
        Response::json(data: $result);
    }
}