<?php

namespace Unit\Validator;

// Autoload files using the Composer autoloader.
require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Exceptions\NotFoundException;
use App\Exceptions\ValidationException;
use App\Scaffolding\Validator\Validator;
use PHPUnit\Framework\TestCase;

class ValidatorTest extends TestCase
{
    public function testSuppliedValidations(): void
    {
        // Arrange
        $rules = ['number' => 'required|integer'];
        $data = ['number' => 1];

        try {
            //Act
            $validator = new Validator($rules, $data);
            $validator->validate();
        } catch (NotFoundException $e) {
            // "Assert"
            $this->fail(message: $e->getMessage());
        } catch (ValidationException $e) {
            $this->fail($e->getMessage());
        }

        //This is a very dirty solution.
        // We just want to confirm that the Validator runs through without throwing an Exception
        $this->addToAssertionCount(count: 1);
    }

    public function testSuppliedNonExistentValidation(): void {
        // Arrange
        $rules = ['key' => 'NonExistentRule浪'];
        //Assert
        $this->expectException(exception: NotFoundException::class);
        // Act
        $validator = new Validator(rules: $rules, data: []);
        $validator->validate();
    }
}