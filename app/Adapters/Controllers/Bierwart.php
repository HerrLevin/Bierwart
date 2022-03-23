<?php

namespace App\Adapters\Controllers;

use App\Adapters\Response;
use App\Core\BierwartInterface;
use OpenApi\Annotations as OA;

class Bierwart implements BierwartInterface
{
	public function printHelloWorld() {
        return 'Bier Bier Bier Bier!';
    }

    /**
     * @OA\Get(
     *     path="/",
     *     operationId="getBierwartHelloWorld",
     *     summary="Bier Bier Bier Bier!",
     *     tags={"Bierwart"},
     *     @OA\Response(response= 200, description= "AOK")
     * )
     */
    public function getHelloWorld() {
        Response::json(data: $this->printHelloWorld());
    }
}
