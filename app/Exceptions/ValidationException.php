<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class ValidationException extends Exception
{
    public function __construct(protected $rule, protected $key, protected $content, $code = 0, Throwable $previous = null)
    {
        $message = "'" . $this->key."' did not conform to the validation rule '". $this->rule ."'. Content: " . var_export($this->content, true);

        parent::__construct($message, $code, $previous);
    }

    public function getKey() {
        return $this->key;
    }

    public function getContent() {
        return $this->content;
    }

    public function getRule() {
        return $this->rule;
    }
}
