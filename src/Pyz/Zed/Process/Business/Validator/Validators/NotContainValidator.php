<?php

namespace Pyz\Zed\Process\Business\Validator\Validators;

use SprykerMiddleware\Zed\Process\Business\Validator\Validators\AbstractValidator;

class NotContainValidator extends AbstractValidator
{
    public const OPTION_VALUES = 'values';

    /**
     * @var array
     */
    protected $requiredOptions = [self::OPTION_VALUES];

    /**
     * @param mixed $value
     * @param array $payload
     *
     * @return bool
     */
    public function validate($value, array $payload): bool
    {
        if ($value === null || $value === '') {
            return true;
        }

        foreach ($this->getValues() as $optionValue) {
            if (str_contains($value, $optionValue)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return array
     */
    protected function getValues(): array
    {
        return $this->options[static::OPTION_VALUES];
    }
}
