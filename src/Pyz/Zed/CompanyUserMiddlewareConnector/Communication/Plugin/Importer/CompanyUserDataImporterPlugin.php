<?php

namespace Pyz\Zed\CompanyUserMiddlewareConnector\Communication\Plugin\Importer;

use Pyz\Zed\Process\Dependency\Plugin\Importer\DataImporterPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Pyz\Zed\CompanyUserMiddlewareConnector\Communication\CompanyUserMiddlewareConnectorCommunicationFactory getFactory()
 * @method \Pyz\Zed\CompanyUserMiddlewareConnector\Business\CompanyUserMiddlewareConnectorFacadeInterface getFacade()
 */
class CompanyUserDataImporterPlugin extends AbstractPlugin implements DataImporterPluginInterface
{
    /**
     * @param array $data
     *
     * @return void
     */
    public function import(array $data): void
    {
        $this->getFacade()->getCompanyUserImporter()->import($data);
    }
}
