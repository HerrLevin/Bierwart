<?php

namespace App\Core;

use App\Exceptions\ValidationException;
use App\Scaffolding\Database\DB;
use App\Scaffolding\Database\SqLite;
use App\Scaffolding\Request;
use App\Scaffolding\Response;
use OpenApi\Annotations as OA;

class BeverageController
{

    /**
     * @OA\Get(
     *     path="/drinksoverview",
     *     summary="returns a list of all drinks in the database",
     *     tags={"Beverage"},
     *     @OA\Response(
     *      response=200, description="Success",
     *      @OA\JsonContent(
     *          @OA\Property(property="data", type="array", @OA\Items(
     *              @OA\Property(property="id", description="drink id", type="integer", example="1"),
     *              @OA\Property(property="name", description="Drink name", type="string", example="Iso Sport"),
     *              @OA\Property(property="size", description="Drink size in milliliters", type="integer", example=500),
     *              @OA\Property(property="price", description="Drink price in €-cents", type="integer", example=50)
     *          ))
     *      )
     * )
     * )
     */
    public static function getDrinksOverview():void {
        $result = DB::table("beverage bev")
            ->select(['bev.id', ' bev.name', ' bev.size', ' type.price'])
            ->innerJoin('drink_type type', 'bev.id_drink_type', '=', 'type.id')
            ->get();
        Response::json(data: $result);
    }

    /**
     * @OA\Post(
     *     path="/orderBeverage",
     *     summary="A user consumes or returns one or more drinks",
     *     tags={"Beverage"},
     *     @OA\RequestBody(
     *     required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  required={"id_user", "id_beverage", "quantity"},
     *                  @OA\Property(property="id_user", type="integer", description="id of user", example="1"),
     *                  @OA\Property(property="id_beverage", type="boolean", description="which kind of drink should be moved?", example="1"),
     *                  @OA\Property(property="quantity", type="integer", description="how many drinks should be moved?", example="5")
     *              )
     *          )
     *     ),
     *     @OA\Response(response=201, description="Created")
     * )
     *
     * @throws \App\Exceptions\NotFoundException
     */
    public static function createBeverageMovement(): void
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
        if ($response->pdo->lastInsertId() > 0) {
            Response::status(201);
        }
        Response::status(404);
    }

    /**
     *  Ein Administrator legt ein neues Getränk eines Getränketyps an
     * @todo validate if user is
     * @throws \App\Exceptions\NotFoundException
     *
     * @OA\Post(
     *     path="/createBeverage",
     *     summary="An administrator creates a new drink of a drink type",
     *     tags={"Beverage"},
     *     security={ {"auth": {}} },
     *     @OA\RequestBody(
     *     required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  required={"id_drink_type", "name"},
     *                  @OA\Property(property="id_drink_type", type="integer", description="id of drink type", example="1"),
     *                  @OA\Property(property="name", type="string", description="Name of the drink", example="Duff Beer"),
     *                  @OA\Property(property="size", type="integer", description="Size of this drink in milliliters", example="330"),
     *                  @OA\Property(property="calories", type="integer", description="Energy of the Drink in kcal/100g", example=42, default=0),
     *                  @OA\Property(property="alcohol", type="integer", description="Alcohol amount in one-tenth of a percent by volume (‰). [We're using integers. We hate comma. Deal with it!]", example=45, default=0)
     *              )
     *          )
     *     ),
     *     @OA\Response(response=201, description="Created")
     * )
     */
    private static function createBeverage(): void {
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
        if ($response->pdo->lastInsertId() > 0) {
            Response::status(201);
        }
        Response::status(404);
    }

    /**
     * Ein Administrator legt einen neuen Getränketyp (bspw. Softdrink) mit einem Preis an
     * @todo Check if administrator
     * @throws \App\Exceptions\NotFoundException
     * @OA\Post(
     *     path="/createDrinkType",
     *     summary="An administrator creates a new drink type (e.g. Softdrink) with a fixed price",
     *     tags={"Beverage"},
     *     security={ {"auth": {}} },
     *     @OA\RequestBody(
     *     required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  required={"name", "price"},
     *                  @OA\Property(property="name", type="string", description="Name of the drinktype ", example="Beer"),
     *                  @OA\Property(property="price", type="integer", description="Price of this type in €-cents", example="100")
     *              )
     *          )
     *     ),
     *     @OA\Response(response=201, description="Created")
     * )
     */
    public static function createDrinkType(): void {
        $request = new Request();
        try {
            $request->validate(rules: [
                'name' => 'required',
                'price' => 'required|integer|notnegative',
            ]);
        } catch (ValidationException $exception) {
            Response::error(message: $exception->getMessage(), status: 400);
        }

        $response = DB::table("drink_type")->insert($request->validated);
        if ($response->pdo->lastInsertId() > 0) {
            Response::status(201);
        }
        Response::status(404);
    }
}