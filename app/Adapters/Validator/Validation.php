<?php

namespace App\Adapters\Validator;

interface Validation
{
    public function validate(string $key, string $value): bool;
}