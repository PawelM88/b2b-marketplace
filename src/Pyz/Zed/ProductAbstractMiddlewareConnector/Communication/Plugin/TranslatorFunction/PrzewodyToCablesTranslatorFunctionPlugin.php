<?php

declare(strict_types=1);

namespace Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\Plugin\TranslatorFunction;

use Pyz\Zed\ProductAbstractMiddlewareConnector\Business\Translator\TranslatorFunction\PrzewodyToCables;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\TranslatorFunction\GenericTranslatorFunctionPluginInterface;

/**
 * @method \Pyz\Zed\ProductAbstractMiddlewareConnector\Business\ProductAbstractMiddlewareConnectorFacadeInterface getFacade()
 * @method \Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\ProductAbstractMiddlewareConnectorCommunicationFactory getFactory()
 */
class PrzewodyToCablesTranslatorFunctionPlugin extends AbstractPlugin implements GenericTranslatorFunctionPluginInterface
{
    /**
     * @var string
     */
    protected const NAME = 'PrzewodyToCables';

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
        return PrzewodyToCables::class;
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
