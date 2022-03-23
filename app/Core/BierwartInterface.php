<?php

namespace App\Core;

interface BierwartInterface
{
    public function printHelloWorld();

    /**
     * @OA\Get(
     *     path="/",
     *     operationId="getBierwartHelloWorld",
     *     summary="Bier Bier Bier Bier!",
     *     tags={"Bierwart"},
     *     @OA\Response(response= 200, description= "AOK")
     * )
     */
    public function getHelloWorld();
}