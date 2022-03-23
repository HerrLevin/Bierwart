<?php

namespace App\Core;

interface UserControllerInterface
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
    public static function getUserOverview();

    /**
     * Füge einen Nutzer hinzu und erstelle einen passenden Account, falls gewünscht
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
     * @todo check if admin
     */
    public static function createUser();
}