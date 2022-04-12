<?php

namespace App\Adapters\Validator;

use App\Exceptions\ValidationException;

class RuleRequired implements Validation
{

    /**
     * @throws ValidationException
     */
    public function validate(string $key, string $value): bool
    {
        if (isset($key, $value) && (!empty($value) || $value === 0)) {
            return true;
        }

        throw new ValidationException("required", $key, $value);
    }
}