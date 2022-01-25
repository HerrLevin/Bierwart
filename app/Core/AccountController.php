<?php

namespace App\Core;

use App\Scaffolding\Database\DB;
use App\Scaffolding\Response;

class AccountController
{
    public static function getBalances()
    {
        $result = DB::table("user")
            ->select(['SUM(bm.quantity*dt.price) as haben', ' soll', ' soll-SUM(bm.quantity*dt.price) as ist', ' user.id_account'])
            ->innerJoin(table: 'beverage_movement bm', first: 'user.id', operator:'=', second:'bm.id_user')
            ->innerJoin(table: 'beverage', first: 'bm.id_beverage', operator: '=', second: 'beverage.id')
            ->innerJoin(table: 'drink_type dt', first: 'beverage.id_drink_type', operator: '=', second: 'dt.id')
            ->innerJoin(
                table: DB::table(name: "account_movement am")
                    ->select(columns: ['SUM(amount) as soll', 'am.id_account'])
                    ->groupBy(group: 'am.id_account')
                    ->as('test')
                    ->query(),
                first: 'user.id_account',
                operator: '=',
                second: 'test.id_account'
            )
            ->groupBy(group: 'user.id_account')
            ->get();
        Response::json(data: $result);
    }
}