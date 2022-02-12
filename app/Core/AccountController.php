<?php

namespace App\Core;

use App\Exceptions\ValidationException;
use App\Scaffolding\Database\DB;
use App\Scaffolding\Request;
use App\Scaffolding\Response;

class AccountController
{
    /**
     * Returns all account balances with deposit/withdrawal-sum and consumption
     *
     */
    public static function getBalances()
    {
        Response::json(data: self::parseBalances());
    }

    public static function parseBalances($timestamp = "tomorrow") {
        $date = date(format: "Y-m-d", timestamp: strtotime($timestamp));

        return DB::table("user")
            ->select(['SUM(bm.quantity*dt.price) as konsum', ' konto', ' konto-SUM(bm.quantity*dt.price) as ist', ' user.id_account'])
            ->innerJoin(
                table: DB::table(name: 'beverage_movement bm')
                    ->select(columns: ['id_user', 'id_beverage', 'SUM(quantity) as quantity'])
                    ->where(first:'DATE(created_at)', operator: '<', second: "'$date'")
                    ->groupBy(group: 'id_beverage, id_user')
                    ->as(alias: 'bm')
                    ->query(),
                first: 'user.id',
                operator:'=',
                second:'bm.id_user')
            ->innerJoin(table: 'beverage', first: 'bm.id_beverage', operator: '=', second: 'beverage.id')
            ->innerJoin(table: 'drink_type dt', first: 'beverage.id_drink_type', operator: '=', second: 'dt.id')
            ->innerJoin(
                table: DB::table(name: "account_movement am")
                    ->select(columns: ['SUM(amount) as konto', 'am.id_account'])
                    ->where(first:'DATE(created_at)', operator: '<', second: "'$date'")
                    ->groupBy(group: 'am.id_account')
                    ->as('test')
                    ->query(),
                first: 'user.id_account',
                operator: '=',
                second: 'test.id_account'
            )
            ->groupBy(group: 'user.id_account')
            ->get();
    }


    public static function parseDrinksForAccounts($endTimestamp = "tomorrow", $beginTimestamp = "year 0") {
        $endDate = date(format: "Y-m-d", timestamp: strtotime($endTimestamp));
        $beginDate = date(format: "Y-m-d", timestamp: strtotime($beginTimestamp));

        return DB::table(name: 'user')
            ->select(['user.id_account', 'user.id as user', 'dt.name' , 'bm.quantity', 'SUM(bm.quantity * dt.price) as price'])
            ->innerJoin(
                table: DB::table(name: 'beverage_movement bm')
                    ->select(['id_user', 'id_beverage', 'SUM(quantity) as quantity'])
                    ->where(first:'DATE(created_at)', operator: '<', second: "'$endDate'")
                    ->andWhere(first:'DATE(created_at)', operator: '>', second: "'$beginDate'")
                    ->groupBy(group: 'id_beverage, id_user')
                    ->as(alias: 'bm')
                    ->query(),
                first: 'user.id',
                operator: '=',
                second: 'bm.id_user')
            ->innerJoin(table: 'beverage', first: 'bm.id_beverage', operator: '=', second: 'beverage.id')
            ->innerJoin(table: 'drink_type dt', first: 'beverage.id_drink_type', operator: '=', second: 'dt.id')
            ->groupBy(group: 'user.id, dt.name')
            ->get();
    }


    public static function createAccount() {
        $request = new Request();
        try {
            $request->validate(rules: [
                'owner' => 'required|integer|notnegative',
                'deposit' => 'integer'
            ]);
        } catch (ValidationException $exception) {
            Response::error(message: $exception->getMessage(), status: 400);
        }

        $amount = 0;
        if ($request->issetBody(name: "deposit")) {
            $amount = $request->bodyParam(name: "deposit");
        }

        $db = DB::beginTransaction();
        try {
            $db->table("account")
                ->insert(['id_owner' => $request->bodyParam(name: "owner")]);
            $db->table("account_movement")
                ->insert(['id_account' => $db->pdo->lastInsertId(), 'amount' => $amount]);
            $db->commitTransaction();
        } catch (\Exception) {
            $db->rollbackTransaction();
            Response::status(500);
        }

        Response::status(201);
    }


    /**
     * Ein Nutzer Geld in seinen Account ein oder aus
     */
    public static function createAccountMovement() {
        $request = new Request();
        try {
            $request->validate(rules: [
                'id_account' => 'required|integer|notnegative',
                'amount' => 'required|integer',
                'is_deposit' => 'bool',
                'comment' => 'nullable'
            ]);
        } catch (ValidationException $exception) {
            Response::error(message: $exception->getMessage(), status: 400);
        }
            $db = DB::table("account_movement")->insert($request->validated);

        if ($db->pdo->lastInsertId() > 0) {
            Response::status(201);
        }
        Response::status(404);
    }
}