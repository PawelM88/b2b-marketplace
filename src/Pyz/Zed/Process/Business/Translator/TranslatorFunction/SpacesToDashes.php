<?php

declare(strict_types=1);

namespace Pyz\Zed\Process\Business\Translator\TranslatorFunction;

use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\AbstractTranslatorFunction;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\TranslatorFunctionInterface;

class SpacesToDashes extends AbstractTranslatorFunction implements TranslatorFunctionInterface
{
    /**
     * @var string
     */
    protected const CHAR_SPACE = ' ';

    /**
     * @var string
     */
    protected const CHAR_DASH = '-';

    /**
     * @param mixed $value
     * @param array<mixed> $payload
     *
     * @return mixed
     */
    public function translate(mixed $value, array $payload): mixed
    {
        return str_replace(static::CHAR_SPACE, static::CHAR_DASH, $value);
    }
}
