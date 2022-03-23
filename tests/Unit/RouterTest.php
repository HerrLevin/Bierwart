<?php

namespace Unit;

// Autoload files using the Composer autoloader.
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Adapters\Router;
use Exception;
use PHPUnit\Framework\TestCase;
use Mockery as m;

class RouterTest extends TestCase
{

    public function testGetRoute():void
    {
        try {
            $mock = m::mock('overload:App\Adapters\Helpers');
            $mock->shouldReceive('dd')->andThrow(new Exception);
            $this->mockHTTPRequest(path: '/get');
        } catch (Exception) {
        }
        $this->expectOutputString('getRoute');
        $this->assertEquals(expected: 200, actual: http_response_code());
    }

    public function testPostRoute():void {
        try {
            $mock = m::mock('overload:App\Adapters\Helpers');
            $mock->shouldReceive('dd')->andThrow(new Exception);
            $this->mockHTTPRequest(path: '/post', method: 'POST');
        } catch (Exception) {
        }
        $this->expectOutputString('postRoute');
        $this->assertEquals(expected: 200, actual: http_response_code());
    }

    public function testGet405():void {
        try {
            $mock = m::mock('overload:App\Adapters\Helpers');
            $mock->shouldReceive('dd')->andThrow(new Exception);
            $this->mockHTTPRequest(path: '/get', method: 'POST');
        } catch (Exception) {
        }
        $this->expectOutputString('{"message": "Method not allowed!"}');
        $this->assertEquals(expected: 405, actual: http_response_code());
    }

    public function testPost405():void {
        try {
            $mock = m::mock('overload:App\Adapters\Helpers');
            $mock->shouldReceive('dd')->andThrow(new Exception);
            $this->mockHTTPRequest(path: '/post');
        } catch (Exception) {
        }
        $this->expectOutputString('{"message": "Method not allowed!"}');
        $this->assertEquals(expected: 405, actual: http_response_code());
    }

    public function testGetRouteNotFound():void {
        try {
            $mock = m::mock('overload:App\Adapters\Helpers');
            $mock->shouldReceive('dd')->andThrow(new Exception);
            $this->mockHTTPRequest(path: '/notDefinedRoute');
        }catch (Exception) {
        }
        $this->expectOutputString('{"message": "Resource not found!"}');
        $this->assertEquals(expected: 404, actual: http_response_code());
    }

    public function testPostRouteNotFound():void {
        try {
            $mock = m::mock('overload:App\Adapters\Helpers');
            $mock->shouldReceive('dd')->andThrow(new Exception);
            $this->mockHTTPRequest(path: '/notDefinedRoute', method: 'POST');
        } catch (Exception) {
        }
        $this->expectOutputString('{"message": "Resource not found!"}');
        $this->assertEquals(expected: 404, actual: http_response_code());
    }

    public function testWrongRouterUsage():void {
        try {
            $mock = m::mock('overload:App\Adapters\Helpers');
            $mock->shouldReceive('dd')->andThrow(new Exception);
            $this->mockHTTPRequest(path: '/missmatchMethod', method: 'GET');
        } catch (Exception) {
        }
        $this->expectOutputString('{"message": "Call to undefined method Unit\RouterTest::thisDoesNotExist()"}');
        $this->assertEquals(expected: 500, actual: http_response_code());
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