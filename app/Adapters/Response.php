<?php

namespace App\Adapters;

class Response
{
    public static function json(array|string|null $data, int $status=200) {
        http_response_code($status);
        header('Access-Control-Allow-Origin: *');
        echo json_encode(["data" => $data], JSON_PARTIAL_OUTPUT_ON_ERROR);
        Helpers::dd();
    }

    public static function status($status=200) {
        http_response_code($status);
        header('Access-Control-Allow-Origin: *');
        Helpers::dd();
    }

    public static function error($message="Resource not found", $status=404) {
        http_response_code($status);
        header('Access-Control-Allow-Origin: *');
        echo json_encode(["error" => ["message" => $message, "status" => $status]], JSON_PARTIAL_OUTPUT_ON_ERROR);
        Helpers::dd();
    }
}