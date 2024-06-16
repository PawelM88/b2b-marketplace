<?php

declare(strict_types=1);

namespace Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\Plugin\Configuration;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ConfigurationProfilePluginInterface;

/**
 * @method \Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\ProductAbstractMiddlewareConnectorCommunicationFactory getFactory()
 * @method \Pyz\Zed\ProductAbstractMiddlewareConnector\Business\ProductAbstractMiddlewareConnectorFacadeInterface getFacade()
 */
class ProductAbstractMiddlewareConnectorConfigurationProfilePlugin extends AbstractPlugin implements ConfigurationProfilePluginInterface
{
    /**
     * @return array<\SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface>
     */
    public function getProcessConfigurationPlugins(): array
    {
        return $this->getFactory()
            ->getProductAbstractProcesses();
    }

    /**
     * @return array<\SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\TranslatorFunctionInterface>
     */
    public function getTranslatorFunctionPlugins(): array
    {
        return $this->getFactory()
            ->getProductAbstractTranslatorFunctions();
    }

    /**
     * @return array<\SprykerMiddleware\Zed\Process\Dependency\Plugin\Validator\ValidatorPluginInterface>
     */
    public function getValidatorPlugins(): array
    {
        return $this->getFactory()
            ->getProductAbstractValidatorPlugins();
    }
}
