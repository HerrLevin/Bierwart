<?php

namespace App\Adapters\Validator;

use App\Exceptions\ValidationException;

class RuleNotNegative implements Validation
{

    /**
     * @throws ValidationException
     */
    public function validate($key, $value)
    {
        if ($value >= 0 || empty($value)) {
            return true;
        }

        throw new ValidationException("notnegative", $key, $value);
    }
}