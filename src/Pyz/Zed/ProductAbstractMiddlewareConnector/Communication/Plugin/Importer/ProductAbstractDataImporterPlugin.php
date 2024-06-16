<?php

declare(strict_types=1);

namespace Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\Plugin\Importer;

use Pyz\Zed\Process\Dependency\Plugin\Importer\DataImporterPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\ProductAbstractMiddlewareConnectorCommunicationFactory getFactory()
 * @method \Pyz\Zed\ProductAbstractMiddlewareConnector\Business\ProductAbstractMiddlewareConnectorFacadeInterface getFacade()
 */
class ProductAbstractDataImporterPlugin extends AbstractPlugin implements DataImporterPluginInterface
{
    /**
     * @param array<mixed> $data
     *
     * @return void
     */
    public function import(array $data): void
    {
        $this->getFacade()->getProductAbstractImporter()->import($data);
    }
}
