<?php

namespace App\Core;

use App\Exceptions\ValidationException;
use App\Scaffolding\Database\SqLite;
use App\Scaffolding\DB;
use App\Scaffolding\Request;
use App\Scaffolding\Response;

class BeverageController
{
    public static function getDrinksOverview():void {
        $db = new DB();
        $db->query("SELECT bev.id, bev.name, bev.size, type.price FROM beverage bev INNER JOIN drink_type type ON bev.id_drink_type = type.id");
        Response::json(data: $db->get());
    }

    public static function createBeverageMovement($args): void
    {
        $request = new Request();
        try {
            $request->validate(rules: [
                'id_user' => 'required|integer',
                'id_beverage' => 'required|integer',
                'quantity' => 'required|integer'
            ]);
        } catch (ValidationException $exception) {
            Response::error(message: $exception->getMessage(), status: 400);
        }

        $sqlite = new SqLite();
        $response = $sqlite->table("beverage_movement")->insert($request->validated);
        if ($response > 0) {
            Response::status(201);
        }
        Response::status(404);
    }

    public static function createBeverage(): void {
        $request = new Request();
        try {
            $request->validate(rules: [
                'drinkType' => 'required|integer',
                'name' => 'required',
                'size' => 'required|integer'
            ]);
        } catch (ValidationException $exception) {
            Response::error(message: $exception->getMessage(), status: 400);
        }

        $db = new DB();
        $db->query("
            INSERT INTO 
            beverage_movement 
                (id_user,id_beverage,quantity) 
            VALUES 
                   (".$request->bodyParam(name: 'uid').", 
                    ".$request->bodyParam(name: 'bid').",
                    ".$request->bodyParam(name: 'qty').");"
        );
        $db->query("
            INSERT INTO beverage 
                (id_drink_type,name,\"size\",calories,alcohol)
            VALUES 
                (1,'Mate',500,20,0);
        ");
        $db->execute();
        Response::status(201);
    }
}