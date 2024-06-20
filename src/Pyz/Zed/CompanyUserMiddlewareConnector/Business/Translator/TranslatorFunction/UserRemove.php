<?php

namespace Pyz\Zed\CompanyUserMiddlewareConnector\Business\Translator\TranslatorFunction;

use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\AbstractTranslatorFunction;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\TranslatorFunctionInterface;

class UserRemove extends AbstractTranslatorFunction implements TranslatorFunctionInterface
{
    /**
     * @var string
     */
    protected const CHAR_USER = 'user:';

    /**
     * @var string
     */
    protected const CHAR_DASH = '-';

    /**
     * @param mixed $value
     * @param array $payload
     * @return mixed
     */
    public function translate($value, array $payload): mixed
    {
        return str_replace(static::CHAR_USER, static::CHAR_DASH, $value);
    }
}
