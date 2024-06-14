<?php

declare(strict_types=1);

namespace Pyz\Zed\MerchantPaymentCommissionDataImport\Business;

use Generated\Shared\Transfer\DataImporterConfigurationTransfer;
use Generated\Shared\Transfer\DataImporterReportTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pyz\Zed\MerchantPaymentCommissionDataImport\Business\MerchantPaymentCommissionDataImportBusinessFactory getFactory()
 */
class MerchantPaymentCommissionDataImportFacade extends AbstractFacade implements
    MerchantPaymentCommissionDataImportFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\DataImporterConfigurationTransfer|null $dataImporterConfigurationTransfer
     *
     * @return \Generated\Shared\Transfer\DataImporterReportTransfer
     */
    public function importMerchantPaymentCommission(
        ?DataImporterConfigurationTransfer $dataImporterConfigurationTransfer = null,
    ): DataImporterReportTransfer {
        return $this->getFactory()
            ->createMerchantPaymentCommissionDataImport($dataImporterConfigurationTransfer)
            ->import($dataImporterConfigurationTransfer);
    }
}
