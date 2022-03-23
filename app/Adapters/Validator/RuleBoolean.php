<?php

namespace App\Adapters\Validator;

use App\Exceptions\ValidationException;

class RuleBoolean implements Validation
{

    /**
     * @throws ValidationException
     */
    public function validate($key, $value)
    {
        if (is_bool($value) || empty($value)) {
            return true;
        }

        throw new ValidationException("integer", $key, $value);
    }
}