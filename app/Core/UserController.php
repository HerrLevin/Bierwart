<?php

namespace App\Core;

use App\Exceptions\ValidationException;
use App\Scaffolding\Database\DB;
use App\Scaffolding\Request;
use App\Scaffolding\Response;

class UserController
{
    public static function getUserOverview()
    {
        $result = DB::table("user")
            ->select(['user.id', 'user.name', 'r.name as role'])
            ->innerJoin('role r', 'user.id_role', '=', 'r.id')
            ->get();
        Response::json(data: $result);
    }

    /**
     * Füge einen Nutzer hinzu und erstelle einen passenden Account, falls gewünscht
     *
     * @throws \App\Exceptions\NotFoundException
     */
    public static function createUser()
    {
        $request = new Request();
        try {
            $request->validate(rules: [
                'name' => 'required',
                'mail' => 'mail',
                'id_role' => 'integer|required',
                'admin' => 'bool',
                'id_account' => 'integer'
            ]);
        } catch (ValidationException $exception) {
            Response::error(message: $exception->getMessage(), status: 400);
        }

        $db = DB::beginTransaction();
        try {
            $db->table(name: 'user')
                ->insert($request->validated);
            if (!$request->issetBody(name: 'id_account')) {
                // Create account for user
                $user = $db->pdo->lastInsertId();
                $db->table(name: "account")
                    ->insert(['id_owner' => $user]);

                //add 0 money to account
                $account = $db->pdo->lastInsertId();
                $db->table(name: "account_movement")
                    ->insert(['id_account' => $account, 'amount' => 0]);

                // set id_account for user
                $db->table(name: 'user')
                    ->update(data: ['id_account' => $account])
                    ->where(first: 'id', operator: '=', second: $user)
                    ->execute();

                if ($db->pdo->errorCode() !== "00000") {
                    throw new \Exception();
                }

            }
            $db->commitTransaction();
        } catch (\Exception) {
            $db->rollbackTransaction();
            Response::status(501);
        }

        Response::status(201);
    }
}