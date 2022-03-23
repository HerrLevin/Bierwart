<?php

namespace App\Adapters\Validator;

interface Validation
{
    public function validate($key, $value);
}