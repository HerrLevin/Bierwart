<?php

namespace App\Adapters\Validator;

use App\Exceptions\NotFoundException;
use App\Exceptions\ValidationException;

class Validator
{

    public function __construct(protected array $rules, protected array $data) {
    }

    /**
     * @throws ValidationException
     * @throws NotFoundException
     */
    public function validate(): void
    {
        foreach ($this->rules as $key => $ruleset) {
            $validatable = new Validatable(key: $key, value: $this->getValidatableContent($key), ruleset: $ruleset);
            $validatable->validateRules();
        }
    }

    private function getValidatableContent(string $key): string {
        return $this->data[$key] ?? "";
    }
}