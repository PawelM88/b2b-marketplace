<?php

declare(strict_types=1);

namespace Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\Plugin;

use Generated\Shared\Transfer\MapperConfigTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface;

/**
 * @method \Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\ProductAbstractMiddlewareConnectorCommunicationFactory getFactory()
 * @method \Pyz\Zed\ProductAbstractMiddlewareConnector\Business\ProductAbstractMiddlewareConnectorFacadeInterface getFacade()
 */
class ProductAbstractMapperStagePlugin extends AbstractPlugin implements StagePluginInterface
{
    /**
     * @var string
     */
    protected const PLUGIN_NAME = 'ProductAbstractMapperStagePlugin';

    /**
     * @return \Generated\Shared\Transfer\MapperConfigTransfer
     */
    protected function getMapperConfig(): MapperConfigTransfer
    {
        return $this->getFacade()
            ->getProductAbstractMapperConfig();
    }

    /**
     * @param mixed $payload
     * @param \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface $outStream
     * @param mixed $originalPayload
     *
     * @return mixed
     */
    public function process(mixed $payload, WriteStreamInterface $outStream, $originalPayload): mixed
    {
        return $this->getFactory()
            ->getProcessFacade()
            ->map($payload, $this->getMapperConfig());
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return static::PLUGIN_NAME;
    }
}
