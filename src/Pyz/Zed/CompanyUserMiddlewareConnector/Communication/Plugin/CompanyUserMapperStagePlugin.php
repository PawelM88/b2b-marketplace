<?php

namespace Pyz\Zed\CompanyUserMiddlewareConnector\Communication\Plugin;

use Generated\Shared\Transfer\MapperConfigTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface;

/**
 * @method \Pyz\Zed\CompanyUserMiddlewareConnector\Communication\CompanyUserMiddlewareConnectorCommunicationFactory getFactory()
 * @method \Pyz\Zed\CompanyUserMiddlewareConnector\Business\CompanyUserMiddlewareConnectorFacadeInterface getFacade()
 */
class CompanyUserMapperStagePlugin extends AbstractPlugin implements StagePluginInterface
{
    /**
     * @var string
     */
    protected const PLUGIN_NAME = 'CompanyUserMapperStagePlugin';

    /**
     * @return \Generated\Shared\Transfer\MapperConfigTransfer
     */
    protected function getMapperConfig(): MapperConfigTransfer
    {
        return $this->getFacade()
            ->getCompanyUserMapperConfig();
    }

    /**
     * @param mixed $payload
     * @param \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface $outStream
     * @param mixed $originalPayload
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return array
     */
    public function process($payload, WriteStreamInterface $outStream, $originalPayload): array
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
