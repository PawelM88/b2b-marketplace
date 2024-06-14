<?php

declare(strict_types=1);

namespace Pyz\Zed\MerchantPaymentCommissionDataImport\Communication\Plugin\DataImport;

use Generated\Shared\Transfer\DataImporterConfigurationTransfer;
use Generated\Shared\Transfer\DataImporterReportTransfer;
use Pyz\Zed\MerchantPaymentCommissionDataImport\MerchantPaymentCommissionDataImportConfig;
use Spryker\Zed\DataImport\Dependency\Plugin\DataImportPluginInterface;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \Pyz\Zed\MerchantPaymentCommissionDataImport\Business\MerchantPaymentCommissionDataImportFacadeInterface getFacade()
 * @method \Pyz\Zed\MerchantPaymentCommissionDataImport\MerchantPaymentCommissionDataImportConfig getConfig()
 */
class MerchantPaymentCommissionDataImportPlugin extends AbstractPlugin implements DataImportPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\DataImporterConfigurationTransfer|null $dataImporterConfigurationTransfer
     *
     * @return \Generated\Shared\Transfer\DataImporterReportTransfer
     */
    public function import(?DataImporterConfigurationTransfer $dataImporterConfigurationTransfer = null): DataImporterReportTransfer
    {
        return $this->getFacade()->importMerchantPaymentCommission($dataImporterConfigurationTransfer);
    }

    /**
     * @return string
     */
    public function getImportType(): string
    {
        return MerchantPaymentCommissionDataImportConfig::IMPORT_TYPE_MERCHANT_PAYMENT_COMMISSION;
    }
}
