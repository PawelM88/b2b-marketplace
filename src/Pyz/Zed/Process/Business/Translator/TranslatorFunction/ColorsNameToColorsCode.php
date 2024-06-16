<?php

declare(strict_types=1);

namespace Pyz\Zed\Process\Business\Translator\TranslatorFunction;

use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\AbstractTranslatorFunction;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\TranslatorFunctionInterface;

class ColorsNameToColorsCode extends AbstractTranslatorFunction implements TranslatorFunctionInterface
{
    /**
     * @var array<string>
     */
    protected const COLORS_NAME_CODE_ARRAY = [
        'white' => '#FFFFFF',
        'red' => '#FF0000',
        'green' => '#00FF00',
        'blue' => '#0000FF',
    ];

    /**
     * @param mixed $value
     * @param array<mixed> $payload
     *
     * @return mixed
     */
    public function translate(mixed $value, array $payload): mixed
    {
        if (array_key_exists($value, self::COLORS_NAME_CODE_ARRAY)) {
            return self::COLORS_NAME_CODE_ARRAY[$value];
        }

        return $value;
    }
}
