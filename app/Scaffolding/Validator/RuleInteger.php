<?php

namespace App\Scaffolding\Validator;

use App\Exceptions\ValidationException;

class RuleInteger implements Validation
{

    /**
     * @throws ValidationException
     */
    public function validate($key, $value)
    {
        if (is_int($value) || empty($value)) {
            return true;
        }

        throw new ValidationException("integer", $key, $value);
    }
}