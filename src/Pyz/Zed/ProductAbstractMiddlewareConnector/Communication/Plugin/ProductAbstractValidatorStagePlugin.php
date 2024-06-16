<?php

declare(strict_types=1);

namespace Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\Plugin;

use Generated\Shared\Transfer\ValidatorConfigTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface;

/**
 * @method \Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\ProductAbstractMiddlewareConnectorCommunicationFactory getFactory()
 * @method \Pyz\Zed\ProductAbstractMiddlewareConnector\Business\ProductAbstractMiddlewareConnectorFacadeInterface getFacade()
 */
class ProductAbstractValidatorStagePlugin extends AbstractPlugin implements StagePluginInterface
{
    /**
     * @var string
     */
    protected const PLUGIN_NAME = 'ProductAbstractValidatorStagePlugin';

    /**
     * @return \Generated\Shared\Transfer\ValidatorConfigTransfer
     */
    protected function getValidatorConfig(): ValidatorConfigTransfer
    {
        return $this->getFacade()
            ->getProductAbstractValidatorConfig();
    }

    /**
     * @param mixed $payload
     * @param \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface $outStream
     * @param mixed $originalPayload
     *
     * @return mixed
     */
    public function process(mixed $payload, WriteStreamInterface $outStream, mixed $originalPayload): mixed
    {
        return $this->getFactory()
            ->getProcessFacade()
            ->validate($payload, $this->getValidatorConfig());
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return static::PLUGIN_NAME;
    }
}
