<?php

declare(strict_types=1);

namespace Pyz\Zed\ProductAbstractMiddlewareConnector\Communication;

use Pyz\Zed\Process\Business\Stream\StreamFactory;
use Pyz\Zed\Process\Business\Stream\StreamFactoryInterface;
use Pyz\Zed\ProductAbstractMiddlewareConnector\ProductAbstractMiddlewareConnectorDependencyProvider;
use SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface;
use SprykerMiddleware\Zed\Process\Communication\ProcessCommunicationFactory;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Iterator\ProcessIteratorPluginInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Log\MiddlewareLoggerConfigPluginInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\InputStreamPluginInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\OutputStreamPluginInterface;

/**
 * @method \Pyz\Zed\ProductAbstractMiddlewareConnector\Business\ProductAbstractMiddlewareConnectorFacadeInterface getFacade()
 */
class ProductAbstractMiddlewareConnectorCommunicationFactory extends ProcessCommunicationFactory
{
    /**
     * @return \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface
     */
    public function getProcessFacade(): ProcessFacadeInterface
    {
        return $this->getProvidedDependency(ProductAbstractMiddlewareConnectorDependencyProvider::FACADE_PROCESS);
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\InputStreamPluginInterface
     */
    public function getProductAbstractInputStreamPlugin(): InputStreamPluginInterface
    {
        return $this->getProvidedDependency(ProductAbstractMiddlewareConnectorDependencyProvider::PRODUCT_ABSTRACT_INPUT_STREAM_PLUGIN);
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\OutputStreamPluginInterface
     */
    public function getProductAbstractOutputStreamPlugin(): OutputStreamPluginInterface
    {
        return $this->getProvidedDependency(ProductAbstractMiddlewareConnectorDependencyProvider::PRODUCT_ABSTRACT_OUTPUT_STREAM_PLUGIN);
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Iterator\ProcessIteratorPluginInterface
     */
    public function getProductAbstractIteratorPlugin(): ProcessIteratorPluginInterface
    {
        return $this->getProvidedDependency(ProductAbstractMiddlewareConnectorDependencyProvider::PRODUCT_ABSTRACT_ITERATOR_PLUGIN);
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Log\MiddlewareLoggerConfigPluginInterface
     */
    public function getProductAbstractLoggerConfigPlugin(): MiddlewareLoggerConfigPluginInterface
    {
        return $this->getProvidedDependency(ProductAbstractMiddlewareConnectorDependencyProvider::PRODUCT_ABSTRACT_LOGGER_PLUGIN);
    }

    /**
     * @return array<\SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface>
     */
    public function getProductAbstractStagePluginStack(): array
    {
        return $this->getProvidedDependency(ProductAbstractMiddlewareConnectorDependencyProvider::PRODUCT_ABSTRACT_STAGE_PLUGIN_STACK);
    }

    /**
     * @return array<\SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface>
     */
    public function getProductAbstractProcesses(): array
    {
        return $this->getProvidedDependency(ProductAbstractMiddlewareConnectorDependencyProvider::PRODUCT_ABSTRACT_PROCESSES);
    }

    /**
     * @return array<\SprykerMiddleware\Zed\Process\Dependency\Plugin\Validator\ValidatorPluginInterface>
     */
    public function getProductAbstractValidatorPlugins(): array
    {
        return $this->getProvidedDependency(ProductAbstractMiddlewareConnectorDependencyProvider::PRODUCT_ABSTRACT_VALIDATOR_PLUGINS);
    }

    /**
     * @return array<\SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\TranslatorFunctionInterface>
     */
    public function getProductAbstractTranslatorFunctions(): array
    {
        return $this->getProvidedDependency(ProductAbstractMiddlewareConnectorDependencyProvider::PRODUCT_ABSTRACT_TRANSLATOR_FUNCTIONS);
    }

    /**
     * @return \Pyz\Zed\Process\Business\Stream\StreamFactoryInterface
     */
    public function createStreamFactory(): StreamFactoryInterface
    {
        return new StreamFactory();
    }
}
