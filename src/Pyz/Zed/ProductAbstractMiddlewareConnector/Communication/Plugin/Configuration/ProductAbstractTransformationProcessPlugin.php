<?php

declare(strict_types=1);

namespace Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\Plugin\Configuration;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Iterator\ProcessIteratorPluginInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Log\MiddlewareLoggerConfigPluginInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\InputStreamPluginInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\OutputStreamPluginInterface;

/**
 * @method \Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\ProductAbstractMiddlewareConnectorCommunicationFactory getFactory()
 * @method \Pyz\Zed\ProductAbstractMiddlewareConnector\Business\ProductAbstractMiddlewareConnectorFacadeInterface getFacade()
 */
class ProductAbstractTransformationProcessPlugin extends AbstractPlugin implements ProcessConfigurationPluginInterface
{
    /**
     * @var string
     */
    protected const PROCESS_NAME = 'PRODUCT_ABSTRACT_PROCESS';

    /**
     * @return string
     */
    public function getProcessName(): string
    {
        return static::PROCESS_NAME;
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\InputStreamPluginInterface
     */
    public function getInputStreamPlugin(): InputStreamPluginInterface
    {
        return $this->getFactory()
            ->getProductAbstractInputStreamPlugin();
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\OutputStreamPluginInterface
     */
    public function getOutputStreamPlugin(): OutputStreamPluginInterface
    {
        return $this->getFactory()
            ->getProductAbstractOutputStreamPlugin();
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Iterator\ProcessIteratorPluginInterface
     */
    public function getIteratorPlugin(): ProcessIteratorPluginInterface
    {
        return $this->getFactory()
            ->getProductAbstractIteratorPlugin();
    }

    /**
     * @return array<\SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface>
     */
    public function getStagePlugins(): array
    {
        return $this->getFactory()
            ->getProductAbstractStagePluginStack();
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Log\MiddlewareLoggerConfigPluginInterface
     */
    public function getLoggerPlugin(): MiddlewareLoggerConfigPluginInterface
    {
        return $this->getFactory()
            ->getProductAbstractLoggerConfigPlugin();
    }

    /**
     * @return array<\SprykerMiddleware\Zed\Process\Dependency\Plugin\Hook\PreProcessorHookPluginInterface>
     */
    public function getPreProcessorHookPlugins(): array
    {
        return [];
    }

    /**
     * @return array<\SprykerMiddleware\Zed\Process\Dependency\Plugin\Hook\PostProcessorHookPluginInterface>
     */
    public function getPostProcessorHookPlugins(): array
    {
        return [];
    }
}
