<?php

declare(strict_types=1);

namespace Pyz\Zed\Process\Communication\Plugin\Validator;

use Pyz\Zed\Process\Business\Validator\Validators\NotContainValidator;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Validator\AbstractGenericValidatorPlugin;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 * @method \SprykerMiddleware\Zed\Process\ProcessConfig getConfig()
 * @method \SprykerMiddleware\Zed\Process\Communication\ProcessCommunicationFactory getFactory()
 */
class NotContainValidatorPlugin extends AbstractGenericValidatorPlugin
{
    /**
     * @var string
     */
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
