<?php

namespace App\Adapters\Validator;

use App\Exceptions\ValidationException;

class RuleNumeric implements Validation
{

    /**
     * @throws ValidationException
     */
    public function validate(string $key, string $value): bool
    {
        if (is_numeric($value) || empty($value)) {
            return true;
        }

        throw new ValidationException("numeric", $key, $value);
    }
}