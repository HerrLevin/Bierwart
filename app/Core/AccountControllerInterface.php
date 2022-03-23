<?php

namespace App\Core;

interface AccountControllerInterface
{
    /**
     * @OA\Get(
     *     tags={"Accounts"},
     *     path="/accountbalances",
     *     operationId="getAccountBalances",
     *     summary="Returns all account balances with deposit/withdrawal-sum and consumption",
     *     @OA\Response(
     *     response=200,
     *     description="OK",
     *          @OA\JsonContent(
     *              @OA\Examples(example="result", value={
     *     "data": {
     *     {
     *     "konsum": 2100,
     *     "konto": 900,
     *     "ist": -1200,
     *     "id_account": 1
     *     },
     *     {
     *     "konsum": 350,
     *     "konto": 500,
     *     "ist": 150,
     *     "id_account": 2
     *     }
     *     }
     *     }, summary="An result object."),
     *          )
     *     )
     *)
     */
    public static function getBalances();

    /**
     * Returns all account balances with deposit/withdrawal-sum and consumption
     *
     */
    public static function parseBalances($timestamp = "tomorrow");

    public static function parseDrinksForAccounts($endTimestamp = "tomorrow", $beginTimestamp = "year 0");

    public static function createAccount();

    /**
     * @OA\Post(
     *     tags={"Accounts"},
     *     path="/createAccountMovement",
     *     operationId="createAccountMovement",
     *     summary="A user deposits or withdraws money from their account",
     *     @OA\RequestBody(
     *     required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  required={"id_account", "amount"},
     *                  @OA\Property(property="id_account", type="integer", description="id of account"),
     *                  @OA\Property(property="amount", type="integer", description="money to be transfered"),
     *                  @OA\Property(property="is_deposit", type="boolean", description="depositing money?", default="false"),
     *                  @OA\Property(property="comment", type="string", description="comment to be added to transfer", default=null)
     *              )
     *          )
     *     ),
     *     @OA\Response(response=201, description="Created")
     *)
     */
    public static function createAccountMovement();
}