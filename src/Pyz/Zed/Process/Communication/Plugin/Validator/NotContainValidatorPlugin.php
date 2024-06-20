<?php

namespace Pyz\Zed\Process\Communication\Plugin\Validator;

use Pyz\Zed\Process\Business\Validator\Validators\NotContainValidator;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Validator\AbstractGenericValidatorPlugin;

class NotContainValidatorPlugin extends AbstractGenericValidatorPlugin
{
    public const NAME = 'NotContain';

    /**
     * @api
     *
     * @return string
     */
    public function getName(): string
    {
        return static::NAME;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getValidatorClassName(): string
    {
        return NotContainValidator::class;
    }
}
