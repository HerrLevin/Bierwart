<?php

namespace App\Adapters;

use JetBrains\PhpStorm\NoReturn;

class Response
{
    #[NoReturn] public static function json(array|string|null $data, int $status=200): void
    {
        http_response_code($status);
        Helpers::setHeader(header: 'Content-Type: application/json');
        Helpers::setHeader(header: 'Access-Control-Allow-Origin: *');
        echo json_encode(["data" => $data], JSON_PARTIAL_OUTPUT_ON_ERROR);
        Helpers::dd();
    }

    #[NoReturn] public static function status($status=200): void
    {
        http_response_code($status);
        Helpers::setHeader(header: 'Access-Control-Allow-Origin: *');
        Helpers::dd();
    }

    #[NoReturn] public static function error($message="Resource not found", $status=404): void
    {
        http_response_code($status);
        Helpers::setHeader(header: 'Access-Control-Allow-Origin: *');
        echo json_encode(["error" => ["message" => $message, "status" => $status]], JSON_PARTIAL_OUTPUT_ON_ERROR);
        Helpers::dd();
    }
}