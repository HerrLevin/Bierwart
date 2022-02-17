<?php

namespace App\Scaffolding\Validator;

use App\Exceptions\ValidationException;

class RuleNullable implements Validation
{

    /**
     * @throws ValidationException
     */
    public function validate($key, $value)
    {
        if (empty($value)) {
            return true;
        }

        throw new ValidationException("nullable", $key, $value);
    }
}