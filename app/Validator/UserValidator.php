<?php

namespace App\Validator;

use App\Models\User;

class UserValidator
{

    public array $rules;

    public function validate(array $data): array
    {
        $result = [];
        $prepareData = $this->prepareData($data);

        foreach ($prepareData as $key => $value) {
            $rules = $this->getRules($key);
            $result = array_merge(
                $result,
                $this->processRules($rules, $key, $value, $prepareData)
            );
        }

        return array_filter($result);
    }

    public function setRules(array $rules): void
    {
        $this->rules = $rules;
    }

    private function prepareData(array $data): array
    {
        $keys = array_keys($this->rules);

        return array_filter(
            $data,
            fn($key) => in_array($key, $keys, true),
            ARRAY_FILTER_USE_KEY
        );
    }

    private function getRules(string $key): array
    {
        $ruleValue = $this->rules[$key];
        return explode("|", $ruleValue);
    }

    private function processRules(
        array  $rules,
        string $key,
        string $value,
        array  $prepareData
    ): array
    {
        $result = [];

        foreach ($rules as $rule) {
            if (str_contains($rule, 'match:')) {
                $result = array_merge(
                    $result,
                    $this->validateMatchRule($key, $value, $prepareData, $rule)
                );
            } else {
                $result = array_merge(
                    $result,
                    $this->validateRegularRule($key, $value, $rule)
                );
            }
        }

        return $result;
    }

    private function validateMatchRule(
        string $key,
        string $value,
        array  $prepareData,
        string $rule
    ): array
    {
        $ruleMatch = explode(':', $rule);
        return [
            self::match($key, $value, $prepareData[$ruleMatch[1]])
        ];
    }

    private function validateRegularRule(
        string $key,
        string $value,
        string $rule
    ): array
    {
        $callable = [self::class, $rule];
        return [
            $callable($key, $value)
        ];
    }

    private static function require(string $key, string $value): string
    {
        if ($value === '') {
            return "The \"{$key}\" field must not be empty!";
        }

        return '';
    }

    private static function unique(string $key, string $value): string
    {
        $model = new User();
        $user = $model->getUserByLogin($value, 'signup');

        if (!empty($user)) {
            return "This data \"{$value}\" is already in use on another account!";
        }

        return '';
    }

    private static function match(
        string $key,
        string $value,
        string $matchValue
    ): string
    {
        if ($value !== $matchValue) {
            return "\"{$key}\" values do not match!";
        }

        return '';
    }

}