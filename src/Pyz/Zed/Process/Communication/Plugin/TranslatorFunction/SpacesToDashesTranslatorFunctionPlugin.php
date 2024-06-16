<?php

declare(strict_types=1);

namespace Pyz\Zed\Process\Communication\Plugin\TranslatorFunction;

use Pyz\Zed\Process\Business\Translator\TranslatorFunction\SpacesToDashes;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\TranslatorFunction\GenericTranslatorFunctionPluginInterface;

/**
 * @method \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface getFacade()
 * @method \SprykerMiddleware\Zed\Process\ProcessConfig getConfig()
 * @method \SprykerMiddleware\Zed\Process\Communication\ProcessCommunicationFactory getFactory()
 */
class SpacesToDashesTranslatorFunctionPlugin extends AbstractPlugin implements GenericTranslatorFunctionPluginInterface
{
    /**
     * @var string
     */
    protected const NAME = 'SpacesToDashes';

    /**
     * @return string
     */
    public function getName(): string
    {
        return static::NAME;
    }

    /**
     * @return string
     */
    public function getTranslatorFunctionClassName(): string
    {
        return SpacesToDashes::class;
    }

    /**
     * @param mixed $value
     * @param array<mixed> $payload
     * @param string $key
     * @param array<mixed> $options
     *
     * @return mixed
     */
    public function translate(mixed $value, array $payload, string $key, array $options): mixed
    {
        $translatorClassName = $this->getTranslatorFunctionClassName();
        $translator = new $translatorClassName();

        return $translator->translate($value, $payload);
    }
}
