<?php

declare(strict_types=1);

namespace Pyz\Zed\MerchantPaymentCommissionDataImport\Business;

use Generated\Shared\Transfer\DataImporterConfigurationTransfer;
use Pyz\Zed\MerchantPaymentCommissionDataImport\Business\DataImportStep\MerchantPaymentCommissionWriterStep;
use Spryker\Zed\DataImport\Business\DataImportBusinessFactory;
use Spryker\Zed\DataImport\Business\Model\DataImporterInterface;

/**
 * @method \Pyz\Zed\MerchantPaymentCommissionDataImport\MerchantPaymentCommissionDataImportConfig getConfig()
 */
class MerchantPaymentCommissionDataImportBusinessFactory extends DataImportBusinessFactory
{
    /**
     * @param \Generated\Shared\Transfer\DataImporterConfigurationTransfer|null $dataImporterConfigurationTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface
     */
    public function createMerchantPaymentCommissionDataImport(
        ?DataImporterConfigurationTransfer $dataImporterConfigurationTransfer = null,
    ): DataImporterInterface {
        $dataImporter = $this->getCsvDataImporterFromConfig($dataImporterConfigurationTransfer);

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker();
        $dataSetStepBroker->addStep($this->createMerchantPaymentCommissionWriterStep());

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    /**
     * @return \Pyz\Zed\MerchantPaymentCommissionDataImport\Business\DataImportStep\MerchantPaymentCommissionWriterStep
     */
    public function createMerchantPaymentCommissionWriterStep(): MerchantPaymentCommissionWriterStep
    {
        return new MerchantPaymentCommissionWriterStep();
    }
}
