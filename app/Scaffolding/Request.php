<?php

namespace App\Scaffolding;

use App\Exceptions\NotFoundException;
use App\Scaffolding\Validator\Validator;

class Request
{

    private null|string $body;
    private null|array $jsonBody;
    public array $validated;

    public function __construct() {
        $this->body = file_get_contents(filename: 'php://input');
        $this->jsonBody = json_decode(json: $this->body, associative: true);
    }

    /**
     * Return value of Post-Request json body param
     * @param string $name
     * @return string|array|null
     * @throws NotFoundException
     */
    public function bodyParam(string $name): string|array|null {
        if (!isset($this->jsonBody[$name])) {
            throw new NotFoundException();
        }
        return $this->jsonBody[$name];
    }

    /**
     * returns unencoded body
     * @return string|null
     */
    public function getBody(): string|null {
        return $this->body;
    }

    public function getJsonBody(): array|null {
        return $this->jsonBody;
    }

    /**
     * @throws \App\Exceptions\ValidationException
     * @throws NotFoundException
     */
    public function validate(array $rules): void
    {
        $validator = new Validator($rules, $this->getJsonBody());
        $validator->validate();
        $this->validated = array_intersect_key($this->getJsonBody(), array_flip(array_keys($rules)));
    }
}