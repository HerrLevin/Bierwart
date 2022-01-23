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
        if (is_int($value)) {
            return true;
        }

        throw new ValidationException("numeric", $key, $value);
    }
}