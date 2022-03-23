<?php

namespace App\Core;

interface BeverageControllerInterface
{
    /**
     * @OA\Get(
     *     path="/drinksoverview",
     *     operationId="getDrinksOverview",
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
    public static function getDrinksOverview(): void;

    /**
     * @OA\Post(
     *     path="/orderBeverage",
     *     operationId="orderBeverage",
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
    public static function createBeverageMovement(): void;

    /**
     *  Ein Administrator legt ein neues Getränk eines Getränketyps an
     * @throws \App\Exceptions\NotFoundException
     *
     * @OA\Post(
     *     path="/createBeverage",
     *     operationId="createNewBeverage",
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
     * @todo validate if user is
     */
    public static function createBeverage(): void;

    /**
     * Ein Administrator legt einen neuen Getränketyp (bspw. Softdrink) mit einem Preis an
     * @throws \App\Exceptions\NotFoundException
     * @OA\Post(
     *     path="/createDrinkType",
     *     operationId="createNewDrinkType",
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
     * @todo Check if administrator
     */
    public static function createDrinkType(): void;
}