<?php

namespace App\Core;

use App\Scaffolding\Response;
use OpenApi\Attributes as OA;

class Bierwart {
	public function printHelloWorld() {
        return 'Bier Bier Bier Bier!';
    }

    #[OA\Get(
        path: '/',
        description: 'Bierwart Demo Bier!',
        responses: [
            new OA\Response(response: 200, description: 'AOK'),
        ]
    )]
    public function getHelloWorld() {
        Response::json(data: $this->printHelloWorld());
    }
}
