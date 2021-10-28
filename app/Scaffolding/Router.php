<?php

namespace App\Scaffolding;


use JetBrains\PhpStorm\NoReturn;
use JsonException;

class Router
{
    private string $request;

    public function __construct($request)
    {
        header('Content-Type: application/json');
        $this->request = $request;
    }

    /**
     * Default "catch if no route", also handles all possible (error) return types with {"message": "foobar"} format
     * @param int $code
     * @param string|null $message
     */
    #[NoReturn] public static function abort(int $code = 404, string $message = null): void
    {
        header('Content-Type: application/json');
        if ($code === 404 && !$message) {
            $message = "Resource not found!";
        }
        http_response_code($code);
        echo '{"message": "' . $message . '"}';
        exit();
    }

    /**
     * HTTP GET routes
     * @param string $route
     * @param string $file
     * @param string $method
     */
    public function get(string $route, string $file, string $method): void
    {
        $uri = trim($this->request, "/");
        $uri = explode("/", $uri);

        if ($uri[0] === trim($route, "/")) {

            array_shift($uri);
            $args = $uri;

            $class = new $file();
            try {
                echo json_encode(["data" => $class->$method($args)], JSON_THROW_ON_ERROR);
                exit();
            } catch (JsonException $e) {
                http_response_code(500);
                echo '{"message": "' . $e->getMessage() . '"}';
            }
        }
    }
}