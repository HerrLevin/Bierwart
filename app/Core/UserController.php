<?php

namespace App\Core;

use App\Scaffolding\DB;

class UserController
{
    public static function getUserOverview() {
        $db = new DB();
        $db->query("SELECT user.id, user.name, r.name as role FROM user INNER JOIN role r ON user.id_role = r.id");
        return $db->get();
    }
}