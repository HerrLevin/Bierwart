<?php

namespace App\Scaffolding\Validator;

interface Validation
{
    public function validate($key, $value);
}