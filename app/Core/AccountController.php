<?php

namespace App\Core;

use App\Scaffolding\DB;

class AccountController
{
    public static function getBalances()
    {
        $db = new DB();
        $db->query("SELECT SUM(bm.quantity*dt.price) as haben, soll, soll-SUM(bm.quantity*dt.price) as ist, user.id_account FROM user
    INNER JOIN beverage_movement bm ON user.id = bm.id_user
    INNER JOIN beverage ON bm.id_beverage = beverage.id
    INNER JOIN drink_type dt ON beverage.id_drink_type = dt.id
    INNER JOIN (SELECT SUM(amount) as soll, am.id_account FROM account_movement am GROUP BY am.id_account) as test ON user.id_account = test.id_account
GROUP BY user.id_account;");
        return $db->get();
    }
}