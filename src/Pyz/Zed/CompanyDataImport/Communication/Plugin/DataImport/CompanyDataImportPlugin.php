<?php

declare(strict_types=1);

namespace Pyz\Zed\CompanyDataImport\Communication\Plugin\DataImport;

use Generated\Shared\Transfer\DataImporterConfigurationTransfer;
use Generated\Shared\Transfer\DataImporterReportTransfer;
use Pyz\Zed\CompanyDataImport\CompanyDataImportConfig;
use Spryker\Zed\DataImport\Dependency\Plugin\DataImportPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Pyz\Zed\CompanyDataImport\Business\CompanyDataImportFacadeInterface getFacade()
 * @method \Pyz\Zed\CompanyDataImport\CompanyDataImportConfig getConfig()
 */
class CompanyDataImportPlugin extends AbstractPlugin implements DataImportPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\DataImporterConfigurationTransfer|null $dataImporterConfigurationTransfer
     *
     * @return \Generated\Shared\Transfer\DataImporterReportTransfer
     */
    public function import(?DataImporterConfigurationTransfer $dataImporterConfigurationTransfer = null): DataImporterReportTransfer
    {
        return $this->getFacade()->importCompany($dataImporterConfigurationTransfer);
    }

    /**
     * @return string
     */
    public function getImportType(): string
    {
        return CompanyDataImportConfig::IMPORT_TYPE_COMPANY;
    }
}
