<?php

namespace Pyz\Zed\CompanyUserMiddlewareConnector\Communication\Plugin;

use Generated\Shared\Transfer\ValidatorConfigTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface;

/**
 * @method \Pyz\Zed\CompanyUserMiddlewareConnector\Communication\CompanyUserMiddlewareConnectorCommunicationFactory getFactory()
 * @method \Pyz\Zed\CompanyUserMiddlewareConnector\Business\CompanyUserMiddlewareConnectorFacadeInterface getFacade()
 */
class CompanyUserValidatorStagePlugin extends AbstractPlugin implements StagePluginInterface
{
    /**
     * @var string
     */
    protected const PLUGIN_NAME = 'CompanyUserValidatorStagePlugin';

    /**
     * @return \Generated\Shared\Transfer\ValidatorConfigTransfer
     */
    protected function getValidatorConfig(): ValidatorConfigTransfer
    {
        return $this->getFacade()
            ->getCompanyUserValidatorConfig();
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
