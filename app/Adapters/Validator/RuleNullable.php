<?php

namespace App\Adapters\Validator;

use App\Exceptions\ValidationException;

class RuleNullable implements Validation
{

    /**
     * @throws ValidationException
     */
    public function validate(string $key, string $value): bool
    {
        if (empty($value)) {
            return true;
        }

        throw new ValidationException("nullable", $key, $value);
    }
}