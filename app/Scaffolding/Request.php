<?php

namespace App\Scaffolding;

use App\Exceptions\NotFoundException;
use App\Scaffolding\Validator\Validator;

class Request
{

    private null|string $body;
    private null|array $jsonBody;
    public array $validated;

    public function __construct(string $body = null) {
        $this->body = $body;
        $this->jsonBody = null;
    }

    public static function create($body = null): static {
        return new static($body);
    }

    /**
     * Return value of Post-Request json body param
     * @param string $name
     * @return string|array|null
     * @throws NotFoundException
     */
    public function bodyParam(string $name): string|array|null {
        $this->prepareJsonBody();
        if (!isset($this->jsonBody[$name])) {
            throw new NotFoundException();
        }
        return $this->jsonBody[$name];
    }

    /**
     * Check if Post-Request body param is set
     * @param string $name
     * @return bool
     */
    public function issetBody(string $name): bool {
        $this->prepareJsonBody();
        if (isset($this->jsonBody[$name])) {
            return true;
        }
        return false;
    }

    /**
     * returns unencoded body
     * @return string|null
     */
    public function getBody(): string|null {
        if ($this->body === null) {
            $this->body = file_get_contents(filename: 'php://input');
        }
        return $this->body;
    }

    public function getJsonBody(): array|null {
        $this->prepareJsonBody();
        return $this->jsonBody;
    }

    private function prepareJsonBody():void {
        if ($this->jsonBody === null) {
            try {
                $this->jsonBody = json_decode(json: $this->getBody(), associative: true, flags: JSON_THROW_ON_ERROR);
            } catch (\JsonException) {
                Response::error(status: 400, message: "Malformatted JSON");
                $this->jsonBody = null;
            }
        }
    }

    /**
     * @throws \App\Exceptions\ValidationException
     * @throws NotFoundException
     */
    public function validate(array $rules): void
    {
        $this->prepareJsonBody();
        $validator = new Validator($rules, $this->getJsonBody());
        $validator->validate();
        $this->validated = array_intersect_key($this->getJsonBody(), array_flip(array_keys($rules)));
    }
}