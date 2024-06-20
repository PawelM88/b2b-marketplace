<?php

namespace Pyz\Zed\CompanyUserMiddlewareConnector\Business\Translator\TranslatorFunction;

use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\AbstractTranslatorFunction;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\TranslatorFunctionInterface;

class CountryNamePlToDe extends AbstractTranslatorFunction implements TranslatorFunctionInterface
{
    /**
     * @var string
     */
    protected const COUNTRY_NAME_PL = 'PL:';

    /**
     * @var string
     */
    protected const COUNTRY_NAME_DE = 'DE--';

    /**
     * @param mixed $value
     * @param array $payload
     * @return mixed
     */
    public function translate($value, array $payload): mixed
    {
        return str_replace(static::COUNTRY_NAME_PL, static::COUNTRY_NAME_DE, $value);
    }
}
