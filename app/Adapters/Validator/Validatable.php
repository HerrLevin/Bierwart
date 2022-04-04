<?php

namespace App\Adapters\Validator;

use App\Exceptions\NotFoundException;
use App\Exceptions\ValidationException;
use JetBrains\PhpStorm\Pure;

class Validatable
{
    protected array $ruleset;
    protected array $registeredRulesets = [
        'required' => RuleRequired::class,
        'numeric' => RuleNumeric::class,
        'integer' => RuleInteger::class,
        'notnegative' => RuleNotNegative::class,
        'mail' => RuleMail::class,
        'bool' => RuleBoolean::class,
        'nullable' => RuleNullable::class
    ];

    #[Pure] public function __construct(protected string $key, protected string $value, string $ruleset)
    {
        $this->ruleset = $this->getRules(ruleset: $ruleset);
    }

    private function getRules(string $ruleset): array
    {
        return explode("|", $ruleset);
    }

    /**
     * @throws NotFoundException
     * @throws ValidationException
     */
    public function validateRules(): void
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
    private function getRule($ruleName)
    {
        if (isset($this->registeredRulesets[$ruleName])) {
            return $this->registeredRulesets[$ruleName];
        }

        throw new NotFoundException();
    }
}