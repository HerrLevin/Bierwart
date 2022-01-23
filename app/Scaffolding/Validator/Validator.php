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

    public function validate(): void
    {
        foreach ($this->rulesArray as $key => $ruleset) {
            new Validatable($key, $this->getValidatableContent($key), $ruleset);
        }
    }

    private function getValidatableContent($key) {
        return $this->data[$key] ?? "";
    }
}