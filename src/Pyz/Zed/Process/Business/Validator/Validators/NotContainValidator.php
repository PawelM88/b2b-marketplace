<?php

declare(strict_types=1);

namespace Pyz\Zed\Process\Business\Validator\Validators;

use SprykerMiddleware\Zed\Process\Business\Validator\Validators\AbstractValidator;

class NotContainValidator extends AbstractValidator
{
    /**
     * @var string
     */
    public const OPTION_VALUES = 'values';

    /**
     * @var array<string>
     */
    protected $requiredOptions = [self::OPTION_VALUES];

    /**
     * @param mixed $value
     * @param array<mixed> $payload
     *
     * @return bool
     */
    public function validate(mixed $value, array $payload): bool
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
     * @return array<string>
     */
    protected function getValues(): array
    {
        return $this->options[static::OPTION_VALUES];
    }
}
