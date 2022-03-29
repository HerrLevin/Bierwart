<?php

namespace App\Adapters\Controllers;

use App\Adapters\Database\DB;
use App\Adapters\Request;
use App\Adapters\Response;
use App\Core\UserControllerInterface;
use App\Exceptions\ValidationException;
use OpenApi\Annotations as OA;

class UserController implements UserControllerInterface
{
    /**
     * @OA\Get(
     *     path="/useroverview",
     *     operationId="getUserOverview",
     *     summary="returns a list of all users in the database",
     *     tags={"User"},
     *     @OA\Response(
     *      response=200, description="Success",
     *      @OA\JsonContent(
     *          @OA\Property(property="data", type="array", @OA\Items(
     *              @OA\Property(property="id", description="Id of user", type="integer", example="1"),
     *              @OA\Property(property="name", description="Name of user", type="string", example="Duff Man"),
     *              @OA\Property(property="role", description="role of a user", type="string", example="resident")
     *          ))
     *      )
     * )
     * )
     */
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
     * @todo check if admin
     * @throws \App\Exceptions\NotFoundException
     * @OA\Post(
     *     path="/createUser",
     *     operationId="createNewUser",
     *     summary="An administrator adds a user and creates an account, if wanted",
     *     tags={"User"},
     *     security={ {"auth": {}} },
     *     @OA\RequestBody(
     *     required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  required={"name", "id_role"},
     *                  @OA\Property(property="name", type="string", description="Name of user ", example="Kearney Zzyzwicz"),
     *                  @OA\Property(property="id_role", type="integer", description="id of the role the user should be added to", example="1"),
     *                  @OA\Property(property="mail", type="string", description="E-Mail address for the user", example="mail@example.com"),
     *                  @OA\Property(property="admin", type="boolean", description="Grant this user admin rights", example="false"),
     *                  @OA\Property(property="id_account", type="integer", description="If supplied, the newly created user's actions get charged to this account. If empty, a new (personal) account is created. Use this, if you want to create a guest-account for regular user.", example="3")
     *              )
     *          )
     *     ),
     *     @OA\Response(response=201, description="Created")
     * )
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