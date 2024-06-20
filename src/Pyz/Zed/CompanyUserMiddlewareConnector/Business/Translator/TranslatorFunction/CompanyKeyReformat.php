<?php

namespace Pyz\Zed\CompanyUserMiddlewareConnector\Business\Translator\TranslatorFunction;

use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\AbstractTranslatorFunction;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\TranslatorFunctionInterface;

class CompanyKeyReformat extends AbstractTranslatorFunction implements TranslatorFunctionInterface
{
    /**
     * @var string
     */
    protected const COMPANY_SPRYKER = 'Spryker';

    /**
     * @var string
     */
    protected const COMPANY_SYSTEMS = '_systems';

    /**
     * @param mixed $value
     * @param array<mixed> $payload
     * @return mixed
     */
    public function translate($value, array $payload): mixed
    {
        if (str_contains($value, static::COMPANY_SPRYKER)) {
            $reformattedKey = strtolower($value);
            $reformattedKey .= static::COMPANY_SYSTEMS;
            return $reformattedKey;
        }

        return $value;
    }
}
