<?php

// Autoload files using the Composer autoloader.
require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Bierwart;
use PHPUnit\Framework\TestCase;

final class HelloWorldTest extends TestCase
{
	public function testPrintHelloWorld() {
		$actualClass = new Bierwart();
        $this->assertEquals('Bier Bier Bier Bier!', $actualClass->printHelloWorld());
	}
}

