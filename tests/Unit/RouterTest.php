<?php

namespace Unit;

// Autoload files using the Composer autoloader.
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Exceptions\TaskFailedSuccessfullyException;
use App\Scaffolding\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{

    public function testGetRoute():void
    {
        $this->expectException(exception: TaskFailedSuccessfullyException::class);
        $this->expectOutputString('getRoute');
        $this->mockHTTPRequest(path: '/get');

        $this->assertEquals(expected: 200, actual: http_response_code());
    }

    public function testPostRoute():void {
        $this->expectException(exception: TaskFailedSuccessfullyException::class);
        $this->expectOutputString('postRoute');
        $this->mockHTTPRequest(path: '/post', method: 'POST');

        $this->assertEquals(expected: 200, actual: http_response_code());
    }

    public function testGet405():void {
        $this->expectException(exception: TaskFailedSuccessfullyException::class);
        $this->expectOutputString('{"message": "Method not allowed!"}');
        $this->mockHTTPRequest(path: '/get', method: 'POST');

        $this->assertEquals(expected: 405, actual: http_response_code());
    }

    public function testPost405():void {
        $this->expectException(exception: TaskFailedSuccessfullyException::class);
        $this->expectOutputString('{"message": "Method not allowed!"}');
        $this->mockHTTPRequest(path: '/post');

        $this->assertEquals(expected: 405, actual: http_response_code());
    }

    public function testGetRouteNotFound():void {
        $this->expectException(exception: TaskFailedSuccessfullyException::class);
        $this->expectOutputString('{"message": "Resource not found!"}');
        $this->mockHTTPRequest(path: '/notDefinedRoute');

        $this->assertEquals(expected: 404, actual: http_response_code());
    }

    public function testPostRouteNotFound():void {
        $this->expectException(exception: TaskFailedSuccessfullyException::class);
        $this->expectOutputString('{"message": "Resource not found!"}');
        $this->mockHTTPRequest(path: '/notDefinedRoute', method: 'POST');

        $this->assertEquals(expected: 404, actual: http_response_code());
    }

    public function testWrongRouterUsage():void {
        $this->expectException(exception: TaskFailedSuccessfullyException::class);
        $this->expectOutputString('{"message": "Call to undefined method Unit\RouterTest::thisDoesNotExist()"}{"message": "Resource not found!"}');
        $this->mockHTTPRequest(path: '/missmatchMethod', method: 'GET');

        $this->assertEquals(expected: 50, actual: http_response_code());
    }

    private function mockHTTPRequest(string $path='/', string $method='GET'):void {
        $_SERVER['REQUEST_URI'] = $path;
        $_SERVER['REQUEST_METHOD'] = $method;

        $this->setupRoutes();
    }

    private function setupRoutes():void {
        $request = $_SERVER['REQUEST_URI'];
        $router = new Router(request: $request, json: false);

        $router->get('/get', $this::class, 'getRoute');
        $router->post('/post', $this::class, 'postRoute');
        $router->get('/missmatchMethod', $this::class, 'thisDoesNotExist');

        Router::abort();
    }

    public function getRoute(): void
    {
        echo "getRoute";
    }

    public function postRoute(): void
    {
        echo "postRoute";
    }

}