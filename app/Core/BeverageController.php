<?php

namespace App\Core;

use App\Exceptions\ValidationException;
use App\Scaffolding\Database\DB;
use App\Scaffolding\Database\SqLite;
use App\Scaffolding\Request;
use App\Scaffolding\Response;

class BeverageController
{
    public static function getDrinksOverview():void {
        $result = DB::table("beverage bev")
            ->select(['bev.id', ' bev.name', ' bev.size', ' type.price'])
            ->innerJoin('drink_type type', 'bev.id_drink_type', '=', 'type.id')
            ->get();
        Response::json(data: $result);
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

        $response = DB::table("beverage_movement")->insert($request->validated);
        if ($response > 0) {
            Response::status(201);
        }
        Response::status(404);
    }

    public static function createBeverage(): void {
        $request = new Request();
        try {
            $request->validate(rules: [
                'id_drink_type' => 'required|integer',
                'name' => 'required',
                'size' => 'numeric',
                'calories' => 'numeric',
                'alcohol' => 'numeric'
            ]);
        } catch (ValidationException $exception) {
            Response::error(message: $exception->getMessage(), status: 400);
        }

        $response = DB::table("beverage")->insert($request->validated);
        if ($response > 0) {
            Response::status(201);
        }
        Response::status(404);
    }
}