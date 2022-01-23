<?php

namespace App\Scaffolding\Validator;

class Validator
{
    protected array $rulesArray;
    protected array $data;

    public function __construct(array $rules, array $data) {
        $this->rulesArray = $rules;
        $this->data = $data;
    }

    /**
     * @throws \App\Exceptions\ValidationException
     * @throws \App\Exceptions\NotFoundException
     */
    public function validate(): void
    {
        foreach ($this->rulesArray as $key => $ruleset) {
            $validatable = new Validatable($key, $this->getValidatableContent($key), $ruleset);
            $validatable->validateRules();
        }
    }

    private function getValidatableContent($key) {
        return $this->data[$key] ?? "";
    }
}