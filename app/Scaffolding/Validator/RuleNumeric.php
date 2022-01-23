<?php

namespace App\Scaffolding\Validator;

use App\Exceptions\ValidationException;

class RuleNumeric implements Validation
{

    /**
     * @throws ValidationException
     */
    public function validate($key, $value)
    {
        if (is_numeric($value) || empty($value)) {
            return true;
        }

        throw new ValidationException("numeric", $key, $value);
    }
}