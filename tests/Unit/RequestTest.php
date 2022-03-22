<?php

namespace Unit;

// Autoload files using the Composer autoloader.
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Exceptions\NotFoundException;
use App\Scaffolding\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    private $jsonData = '{"key": "value", "int": 123, "float": 3.14, "bool": true, "nulled": null}';
    private $data = 'This is beautiful body data!';

    public function testBody()
    {
        $request = Request::create($this->jsonData);
        $body = $request->getBody();
        $this->assertEquals($this->jsonData, $body);

        $request = Request::create($this->data);
        $body = $request->getBody();
        $this->assertEquals($this->data, $body);
    }

    public function testJsonBody() {
        $request = Request::create($this->jsonData);
        $json = $request->getJsonBody();
        var_dump($json);
        $this->assertIsArray($json);
        $this->assertEquals(json_decode($this->jsonData, true), $json);
    }

    public function testFailJsonBody() {
        $request = Request::create($this->data);
        $json = $request->getJsonBody();
        $this->assertNull($json);
    }

    public function testIssetBody() {
        $request = Request::create($this->jsonData);
        $this->assertTrue($request->issetBody('key'));
        $this->assertTrue($request->issetBody('int'));
        $this->assertTrue($request->issetBody('float'));

        $this->assertFalse($request->issetBody('Bielefeld'));
        $this->assertFalse($request->issetBody('Sasquatch'));
    }

    public function testBodyParams() {
        $request = Request::create($this->jsonData);
        $this->assertEquals('value', $request->bodyParam('key'));
        $this->assertEquals(123, $request->bodyParam('int'));
        $this->assertEquals(3.14, $request->bodyParam('float'));
    }

    public function testMissingBodyParams() {
        $request = Request::create($this->jsonData);
        $this->expectException(NotFoundException::class);

        $request->bodyParam('Bielefeld');
    }

    //ToDo: Mock Validator
    public function testRequestValidator() {
        $request = Request::create($this->jsonData);
        $request->validate(['key' => 'required']);

        $this->assertArrayHasKey('key', $request->validated);
    }
}