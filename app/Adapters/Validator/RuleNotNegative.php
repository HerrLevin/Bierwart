<?php

namespace App\Adapters\Validator;

use App\Exceptions\ValidationException;

class RuleNotNegative implements Validation
{

    /**
     * @throws ValidationException
     */
    public function validate(string $key, string $value): bool
    {
        if ($value >= 0 || empty($value)) {
            return true;
        }

        throw new ValidationException("notnegative", $key, $value);
    }
}