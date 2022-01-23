<?php

namespace App\Scaffolding;


use JetBrains\PhpStorm\NoReturn;
use JsonException;
use Prophecy\Exception\Doubler\InterfaceNotFoundException;

class Router
{
    protected string $route;
    protected string $file;
    protected string $method;
    protected string $httpMethod;
    private string $request;

    public function __construct($request)
    {
        header('Content-Type: application/json');
        $this->request = $request;
    }

    /**
     * HTTP GET routes
     * @param string $route
     * @param string $file
     * @param string $method
     */
    public function get(string $route, string $file, $method): void
    {
        $this->route = $route;
        $this->file = $file;
        $this->method = $method;
        $this->httpMethod = 'GET';
        $this->scaffoldRequest();
    }

    protected function scaffoldRequest()
    {
        try {
            $args = $this->matchURI(route: $this->route, method: $this->httpMethod);
            $class = new $this->file();
            echo json_encode(["data" => $class->{$this->method}($args)], JSON_THROW_ON_ERROR);
            exit();
        } catch (JsonException $e) {
            http_response_code(500);
            echo '{"message": "' . $e->getMessage() . '"}';
        } catch (InterfaceNotFoundException) {
            //
        }
    }

    protected function matchURI(string $route, string $method = 'GET'): array
    {
        $uri = trim($this->request, "/");
        $uri = explode("/", $uri);
        if ($uri[0] === trim($route, "/")) {
            array_shift($uri);
            if ($_SERVER['REQUEST_METHOD'] !== $method) {
                self::abort(code: 405, message: 'Method not allowed!');
            }
            return $uri;
        }
        throw new InterfaceNotFoundException("Path not found", $route);
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

    public function post(string $route, string $file, string $method): void
    {
        $this->route = $route;
        $this->file = $file;
        $this->method = $method;
        $this->httpMethod = 'POST';
        $this->scaffoldRequest();
    }
}