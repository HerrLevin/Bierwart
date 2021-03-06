<?php

namespace App\Adapters\Validator;

use App\Exceptions\ValidationException;

class RuleMail implements Validation
{

    /**
     * @throws ValidationException
     */
    public function validate(string $key, string $value): bool
    {
        if (!empty($value) && !preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $value)) {
            throw new ValidationException("mail", $key, $value);
        }
        return true;
    }
}