<?php

namespace App\Scaffolding\Validator;

use App\Exceptions\NotFoundException;

class Validatable
{
    protected $key;
    protected $ruleset;
    protected $value;
    protected array $registeredRulesets = [
      'required' => RuleRequired::class,
      'numeric' => RuleNumeric::class,
      'integer' => RuleInteger::class
    ];

    public function __construct($key, $value, $ruleset) {
        $this->ruleset = $this->getRules($ruleset);
        $this->key = $key;
        $this->value = $value;
        $this->validateRules();
    }

    private function getRules($ruleset): array
    {
        return explode("|", $ruleset);
    }

    private function validateRules(): void
    {
        foreach ($this->ruleset as $rule) {

            $classname = $this->getRule($rule);

            $class = new $classname();
            $class->validate($this->key, $this->value);
        }
    }

    /**
     * @throws NotFoundException
     */
    private function getRule($ruleName) {
        if (isset($this->registeredRulesets[$ruleName])) {
            return $this->registeredRulesets[$ruleName];
        }

        throw new NotFoundException();
    }
}