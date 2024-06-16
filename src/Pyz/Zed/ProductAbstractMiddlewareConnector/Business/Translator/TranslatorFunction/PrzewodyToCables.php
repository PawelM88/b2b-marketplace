<?php

declare(strict_types=1);

namespace Pyz\Zed\ProductAbstractMiddlewareConnector\Business\Translator\TranslatorFunction;

use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\AbstractTranslatorFunction;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\TranslatorFunctionInterface;

class PrzewodyToCables extends AbstractTranslatorFunction implements TranslatorFunctionInterface
{
    /**
     * @var string
     */
    protected const TYPE_PRZEWODY = 'przewody';

    /**
     * @var string
     */
    protected const TYPE_CABLES = 'cables';

    /**
     * @param mixed $value
     * @param array<mixed> $payload
     *
     * @return mixed
     */
    public function translate(mixed $value, array $payload): mixed
    {
        if ($value === static::TYPE_PRZEWODY) {
            return static::TYPE_CABLES;
        }

        return $value;
    }
}
