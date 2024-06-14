<?php

declare(strict_types=1);

namespace Pyz\Zed\CompanyDataImport\Business;

use Generated\Shared\Transfer\DataImporterConfigurationTransfer;
use Pyz\Zed\CompanyDataImport\Business\DataImportStep\CompanyWriterStep;
use Pyz\Zed\CompanyDataImport\CompanyDataImportDependencyProvider;
use Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface;
use Spryker\Zed\DataImport\Business\DataImportBusinessFactory;
use Spryker\Zed\DataImport\Business\Model\DataImporterInterface;

/**
 * @method \Pyz\Zed\CompanyDataImport\CompanyDataImportConfig getConfig()
 */
class CompanyDataImportBusinessFactory extends DataImportBusinessFactory
{
    /**
     * @param \Generated\Shared\Transfer\DataImporterConfigurationTransfer|null $dataImporterConfigurationTransfer
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Spryker\Zed\DataImport\Business\Model\DataImporterInterface
     */
    public function createCompanyDataImport(?DataImporterConfigurationTransfer $dataImporterConfigurationTransfer = null): DataImporterInterface
    {
        $dataImporter = $this->getCsvDataImporterFromConfig($dataImporterConfigurationTransfer);

        $dataSetStepBroker = $this->createTransactionAwareDataSetStepBroker();
        $dataSetStepBroker->addStep($this->createCompanyWriterStep());

        $dataImporter->addDataSetStepBroker($dataSetStepBroker);

        return $dataImporter;
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Zed\CompanyDataImport\Business\DataImportStep\CompanyWriterStep
     */
    protected function createCompanyWriterStep(): CompanyWriterStep
    {
        return new CompanyWriterStep($this->getCompanyRoleFacade());
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface
     */
    protected function getCompanyRoleFacade(): CompanyRoleFacadeInterface
    {
        return $this->getProvidedDependency(CompanyDataImportDependencyProvider::FACADE_COMPANY_ROLE);
    }
}
