<?php

namespace Pyz\Zed\CompanyUserMiddlewareConnector\Communication\Plugin\Stream;

use Pyz\Zed\CompanyUserMiddlewareConnector\Communication\Plugin\Importer\CompanyUserDataImporterPlugin;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\OutputStreamPluginInterface;

/**
 * @method \Pyz\Zed\CompanyUserMiddlewareConnector\Communication\CompanyUserMiddlewareConnectorCommunicationFactory getFactory()
 * @method \Pyz\Zed\CompanyUserMiddlewareConnector\Business\CompanyUserMiddlewareConnectorFacadeInterface getFacade()
 */
class CompanyUserDataImportOutputStreamPlugin extends AbstractPlugin implements OutputStreamPluginInterface
{
    /**
     * @var string
     */
    protected const PLUGIN_NAME = 'CompanyUserDataImportOutputStreamPlugin';

    /**
     * @return string
     */
    public function getName(): string
    {
        return static::PLUGIN_NAME;
    }

    /**
     * @param string $path
     *
     * @return \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface
     */
    public function getOutputStream(string $path): WriteStreamInterface
    {
        $dataImporterPlugin = new CompanyUserDataImporterPlugin();

        return $this->getFactory()
            ->createStreamFactory()
            ->createDataImportWriteStream($dataImporterPlugin);
    }
}
