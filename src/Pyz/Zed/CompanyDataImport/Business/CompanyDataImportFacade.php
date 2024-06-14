<?php

declare(strict_types=1);

namespace Pyz\Zed\CompanyDataImport\Business;

use Generated\Shared\Transfer\DataImporterConfigurationTransfer;
use Generated\Shared\Transfer\DataImporterReportTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pyz\Zed\CompanyDataImport\Business\CompanyDataImportBusinessFactory getFactory()
 */
class CompanyDataImportFacade extends AbstractFacade implements CompanyDataImportFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\DataImporterConfigurationTransfer|null $dataImporterConfigurationTransfer
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Generated\Shared\Transfer\DataImporterReportTransfer
     */
    public function importCompany(?DataImporterConfigurationTransfer $dataImporterConfigurationTransfer = null): DataImporterReportTransfer
    {
        return $this->getFactory()
            ->createCompanyDataImport($dataImporterConfigurationTransfer)
            ->import($dataImporterConfigurationTransfer);
    }
}
