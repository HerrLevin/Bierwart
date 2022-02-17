<?php

namespace App\Scaffolding\Validator;

use App\Exceptions\ValidationException;

class RuleRequired implements Validation
{

    /**
     * @throws ValidationException
     */
    public function validate($key, $value)
    {
        if (isset($key, $value) && (!empty($value) || $value === 0)) {
            return true;
        }

        throw new ValidationException("required", $key, $value);
    }
}