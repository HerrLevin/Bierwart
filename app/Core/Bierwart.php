<?php

namespace App\Core;

use App\Scaffolding\Response;
use OpenApi\Annotations as OA;

class Bierwart {
	public function printHelloWorld() {
        return 'Bier Bier Bier Bier!';
    }

    /**
     * @OA\Get(
     *     path="/",
     *     summary="Bier Bier Bier Bier!",
     *     tags={"Bierwart"},
     *     @OA\Response(response= 200, description= "AOK")
     * )
     */
    public function getHelloWorld() {
        Response::json(data: $this->printHelloWorld());
    }
}
