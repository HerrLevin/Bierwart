<?php

namespace App\Adapters;


use Error;
use JetBrains\PhpStorm\NoReturn;
use JsonException;
use Prophecy\Exception\Doubler\InterfaceNotFoundException;

class Router
{
    protected string $route;
    protected string $file;
    protected string $method;
    protected string $httpMethod;

    public function __construct(private string $request, bool $json=true)
    {
    }

    /**
     * HTTP GET routes
     */
    public function get(string $route, string $file, string $method): void
    {
        $this->route = $route;
        $this->file = $file;
        $this->method = $method;
        $this->httpMethod = 'GET';
        $this->scaffoldRequest();
    }

    /**
     */
    protected function scaffoldRequest(): void
    {
        try {
            http_response_code(200);
            $args = $this->matchURI(route: $this->route, method: $this->httpMethod);
            $class = new $this->file();
            $class->{$this->method}($args);
            Helpers::dd();
        }catch (Error | JsonException $e) {
            http_response_code(500);
            echo '{"message": "' . $e->getMessage() . '"}';
            Helpers::dd();
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
     * @param string|null $message
     */
    #[NoReturn] public static function abort(int $code = 404, string $message = null): void
    {
        if ($code === 404 && !$message) {
            $message = "Resource not found!";
        }
        http_response_code($code);
        echo '{"message": "' . $message . '"}';
        Helpers::dd();
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