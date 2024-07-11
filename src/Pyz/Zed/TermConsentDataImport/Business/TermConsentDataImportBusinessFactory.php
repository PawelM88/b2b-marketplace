<?php

declare(strict_types=1);

namespace Pyz\Zed\TermConsentDataImport\Business;

use Generated\Shared\Transfer\DataImporterConfigurationTransfer;
use Pyz\Zed\TermConsentDataImport\Business\DataImportStep\TermConsentWriterStep;
use Spryker\Zed\DataImport\Business\DataImportBusinessFactory;
use Spryker\Zed\DataImport\Business\Model\DataImporterInterface;

/**
 * @method \Pyz\Zed\TermConsentDataImport\TermConsentDataImportConfig getConfig()
 */
class TermConsentDataImportBusinessFactory extends DataImportBusinessFactory
{
    /**
     * @param \Generated\Shared\Transfer\DataImporterConfigurationTransfer|null $dataImporterConfigurationTransfer
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface
     */
    public function createTermConsentDataImport(
        ?DataImporterConfigurationTransfer $dataImporterConfigurationTransfer = null,
    ): DataImporterInterface {
        $dataImporter = $this->getCsvDataImporterFromConfig($dataImporterConfigurationTransfer);

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker();
        $dataSetStepBroker->addStep($this->createTermConsentWriterStep());

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    /**
     * @return \Pyz\Zed\TermConsentDataImport\Business\DataImportStep\TermConsentWriterStep
     */
    public function createTermConsentWriterStep(): TermConsentWriterStep
    {
        return new TermConsentWriterStep();
    }
}
