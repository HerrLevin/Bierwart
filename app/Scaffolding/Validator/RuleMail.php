<?php

namespace App\Scaffolding\Validator;

use App\Exceptions\ValidationException;

class RuleMail implements Validation
{

    /**
     * @throws ValidationException
     */
    public function validate($key, $value)
    {
        if (!empty($value) && !preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $value)) {
            throw new ValidationException("mail", $key, $value);
        }
        return true;
    }
}