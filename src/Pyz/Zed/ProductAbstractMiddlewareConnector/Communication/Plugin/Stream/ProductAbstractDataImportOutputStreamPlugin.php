<?php

declare(strict_types=1);

namespace Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\Plugin\Stream;

use Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\Plugin\Importer\ProductAbstractDataImporterPlugin;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\OutputStreamPluginInterface;

/**
 * @method \Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\ProductAbstractMiddlewareConnectorCommunicationFactory getFactory()
 * @method \Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\Plugin\Stream\ProductAbstractMiddlewareConnectorFacadeInterface getFacade()
 */
class ProductAbstractDataImportOutputStreamPlugin extends AbstractPlugin implements OutputStreamPluginInterface
{
    /**
     * @var string
     */
    protected const PLUGIN_NAME = 'ProductAbstractDataImportOutputStreamPlugin';

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
        $dataImporterPlugin = new ProductAbstractDataImporterPlugin();

        return $this->getFactory()
            ->createStreamFactory()
            ->createDataImportWriteStream($dataImporterPlugin);
    }
}
