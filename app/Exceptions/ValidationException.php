<?php

namespace App\Exceptions;

use Exception;
use Throwable;

class ValidationException extends Exception
{
    protected $key;
    protected $content;

    public function __construct($rule, $key, $content, $code = 0, Throwable $previous = null)
    {

        $message = "'" . $key."' did not conform to the validation rule '". $rule ."'. Content: " . var_export($content, true);

        $this->key = $key;
        $this->content = $content;

        parent::__construct($message, $code, $previous);
    }

    public function getKey() {
        return $this->key;
    }

    public function getContent() {
        return $this->content;
    }
}
