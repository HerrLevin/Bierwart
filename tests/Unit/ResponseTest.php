<?php

namespace Unit;

// Autoload files using the Composer autoloader.
require_once __DIR__ . '/../../vendor/autoload.php';


use App\Adapters\FileGetContentsWrapper;
use App\Adapters\Response;
use Mockery as m;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testStatus() {
        $mock = m::mock('overload:App\Adapters\Helpers');
        $mock->shouldReceive('dd')
            ->twice();

        Response::status();
        $this->assertSame(200, http_response_code());

        Response::status(404);
        $this->assertSame(404, http_response_code());
    }

    public function testJson() {
        $mock = m::mock('overload:App\Adapters\Helpers');
        $mock->shouldReceive('dd')
            ->times(3);

        Response::json(null);

        $this->expectOutputString(
            '{"data":null}' .
            '{"data":"Hello World!"}' .
            '{"data":{"foo":"bar"}}'
        );

        $this->assertSame(200, http_response_code());

        Response::json('Hello World!');

        Response::json(['foo' => 'bar'], 201);
        $this->assertSame(201, http_response_code());
    }

    public function testError() {
        $mock = m::mock('overload:App\Adapters\Helpers');
        $mock->shouldReceive('dd')
            ->times(3);

        $this->expectOutputString(
            '{"error":{"message":"Resource not found","status":404}}'
            .'{"error":{"message":"This is an error!","status":404}}'
            .'{"error":{"message":"Resource not found","status":500}}'
        );

        Response::error();
        $this->assertSame(404, http_response_code());

        Response::error("This is an error!");

        Response::error(status: 500);
        $this->assertSame(500, http_response_code());


    }

}