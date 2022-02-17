<?php

namespace Unit\Validator;

// Autoload files using the Composer autoloader.
require_once __DIR__ . '/../../../vendor/autoload.php';

use App\Exceptions\ValidationException;
use App\Scaffolding\Validator\Validator;
use PHPUnit\Framework\TestCase;

class ValidationRulesTest extends TestCase
{
    public function testRuleBoolean()
    {
        $rules = ['validate1' => 'bool', 'validate2' => 'bool'];
        $data = ['validate1' => false, 'validate2' => true];

        //Act
        $validator = new Validator($rules, $data);
        $validator->validate();

        $this->addToAssertionCount(count: 2);
    }

    public function testRuleBooleanFail()
    {
        //Arrange
        $rules = ['validate' => 'bool'];
        $data = ['validate' => 'hey, hey apple!'];

        $this->expectException(exception: ValidationException::class);
        $this->expectExceptionMessageMatches(regularExpression: '/bool/');
        $this->expectExceptionMessageMatches(regularExpression: '/validate/');

        //Act
        $validator = new Validator($rules, $data);
        $validator->validate();
    }

    public function testRuleInteger(){
        $rules = ['validate1' => 'integer', 'validate2' => 'integer', 'validate3' => 'integer'];
        $data = ['validate1' => 0, 'validate2' => 1, 'validate3' => -1];

        //Act
        $validator = new Validator($rules, $data);
        $validator->validate();

        $this->addToAssertionCount(count: 3);
    }

    public function testRuleIntegerFailString() {
        //Arrange
        $rules = ['validate' => 'integer'];
        $data = ['validate' => 'hey, hey apple!'];

        $this->expectException(exception: ValidationException::class);
        $this->expectExceptionMessageMatches(regularExpression: '/integer/');
        $this->expectExceptionMessageMatches(regularExpression: '/validate/');

        //Act
        $validator = new Validator($rules, $data);
        $validator->validate();
    }

    public function testRuleIntegerFailFloat() {
        //Arrange
        $rules = ['validate' => 'integer'];
        $data = ['validate' => 3.1415926535];

        $this->expectException(exception: ValidationException::class);
        $this->expectExceptionMessageMatches(regularExpression: '/integer/');
        $this->expectExceptionMessageMatches(regularExpression: '/validate/');

        //Act
        $validator = new Validator($rules, $data);
        $validator->validate();
    }

    public function testRuleIntegerFailBool() {
        //Arrange
        $rules = ['validate' => 'integer'];
        $data = ['validate' => true];

        $this->expectException(exception: ValidationException::class);
        $this->expectExceptionMessageMatches(regularExpression: '/integer/');
        $this->expectExceptionMessageMatches(regularExpression: '/validate/');

        //Act
        $validator = new Validator($rules, $data);
        $validator->validate();
    }

    public function testRuleMail()
    {
        $rules = ['validate1' => 'mail', 'validate2' => 'mail', 'validate3' => 'mail'];
        $data = [
            'validate1' => 'max.mustermann@example.com',
            'validate2' => 'HuereSoh_69+Bierwart@posteo.de',
            'validate3' => 'diesisteine.lange.mail.mitunnoetigerschaisze@government.agencies.co.uk'
        ];

        //Act
        $validator = new Validator($rules, $data);
        $validator->validate();

        $this->addToAssertionCount(count: 3);
    }

    public function testRuleMailFail() {
        //Arrange
        $rules = ['validate' => 'mail'];
        $data = ['validate' => 'hey, hey apple!'];

        $this->expectException(exception: ValidationException::class);
        $this->expectExceptionMessageMatches(regularExpression: '/mail/');
        $this->expectExceptionMessageMatches(regularExpression: '/validate/');

        //Act
        $validator = new Validator($rules, $data);
        $validator->validate();
    }

    public function testRuleNotNegative()
    {
        $rules = [
            'validate1' => 'notnegative',
            'validate2' => 'notnegative',
            'validate3' => 'notnegative',
            'validate4' => 'notnegative'];
        $data = ['validate1' => 0, 'validate2' => 2, 'validate3' => 7.5, 'validate4' => 'öpve'];

        //Act
        $validator = new Validator($rules, $data);
        $validator->validate();

        $this->addToAssertionCount(count: 4);
    }

    public function testRuleNotNegativeFail() {
        //Arrange
        $rules = ['validate' => 'notnegative'];
        $data = ['validate' => -1];

        $this->expectException(exception: ValidationException::class);
        $this->expectExceptionMessageMatches(regularExpression: '/notnegative/');
        $this->expectExceptionMessageMatches(regularExpression: '/validate/');

        //Act
        $validator = new Validator($rules, $data);
        $validator->validate();
    }

    public function testRuleNumeric()
    {
        $rules = ['validate1' => 'numeric', 'validate2' => 'numeric', 'validate3' => 'numeric'];
        $data = ['validate1' => 0, 'validate2' => -2, 'validate3' => 7.5];

        //Act
        $validator = new Validator($rules, $data);
        $validator->validate();

        $this->addToAssertionCount(count: 3);
    }

    public function testRuleNumericFail()
    {
        //Arrange
        $rules = ['validate' => 'numeric'];
        $data = ['validate' => 'öpfel'];

        $this->expectException(exception: ValidationException::class);
        $this->expectExceptionMessageMatches(regularExpression: '/nullable/');
        $this->expectExceptionMessageMatches(regularExpression: '/validate/');

        //Act
        $validator = new Validator($rules, $data);
        $validator->validate();
    }

    public function testRuleNullable()
    {
        $rules = ['validate1' => 'nullable', 'validate2' => 'nullable', 'validate3' => 'nullable'];
        $data = ['validate1' => 0, 'validate2' => null, 'validate3' => ''];

        //Act
        $validator = new Validator($rules, $data);
        $validator->validate();

        $this->addToAssertionCount(count: 3);
    }

    public function testRuleNullableFail()
    {
        //Arrange
        $rules = ['validate' => 'nullable'];
        $data = ['validate' => 'null'];

        $this->expectException(exception: ValidationException::class);
        $this->expectExceptionMessageMatches(regularExpression: '/nullable/');
        $this->expectExceptionMessageMatches(regularExpression: '/validate/');
        //Act
        $validator = new Validator($rules, $data);
        $validator->validate();
    }

    public function testRuleRequired()
    {
        $rules = ['validate1' => 'required', 'validate2' => 'required', 'validate3' => 'required'];
        $data = ['validate1' => 0, 'validate2' => 'asdf', 'validate3' => 47.11];

        //Act
        $validator = new Validator($rules, $data);
        $validator->validate();

        $this->addToAssertionCount(count: 3);
    }

    public function testRuleRequiredNulledFail()
    {
        //Arrange
        $rules = ['validate' => 'required'];
        $data = ['validate' => null];

        $this->expectException(exception: ValidationException::class);
        $this->expectExceptionMessageMatches(regularExpression: '/required/');
        $this->expectExceptionMessageMatches(regularExpression: '/validate/');
        //Act
        $validator = new Validator($rules, $data);
        $validator->validate();
    }

    public function testRuleRequiredUnsetFail()
    {
        //Arrange
        $rules = ['validate' => 'required'];
        $data = [];

        $this->expectException(exception: ValidationException::class);
        $this->expectExceptionMessageMatches(regularExpression: '/required/');
        $this->expectExceptionMessageMatches(regularExpression: '/validate/');
        //Act
        $validator = new Validator($rules, $data);
        $validator->validate();
    }
}