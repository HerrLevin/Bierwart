<?php

namespace App\Adapters\Validator;

use App\Exceptions\ValidationException;

class RuleInteger implements Validation
{

    /**
     * @throws ValidationException
     */
    public function validate(string $key, string $value): bool
    {
        if (is_int($value) || empty($value)) {
            return true;
        }

        throw new ValidationException("integer", $key, $value);
    }
}