<?php

namespace Pyz\Zed\CompanyUserMiddlewareConnector\Business;

use Pyz\Zed\Process\Business\Importer\Importer;
use Pyz\Zed\CompanyUserMiddlewareConnector\Business\Mapper\Map\CompanyUserMap;
use Pyz\Zed\CompanyUserMiddlewareConnector\Business\Translator\Dictionary\CompanyUserDictionary;
use Pyz\Zed\CompanyUserMiddlewareConnector\Business\Validator\ValidationRuleSet\CompanyUserValidationRuleSet;
use Pyz\Zed\Process\Business\Importer\ImporterInterface;
use Spryker\Zed\CompanyUserDataImport\Business\Model\CompanyUser\CompanyUserWriterStep;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSet;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBroker;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerInterface;
use Spryker\Zed\DataImport\Business\Model\Publisher\DataImporterPublisher;
use Spryker\Zed\DataImport\Business\Model\Publisher\DataImporterPublisherInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use SprykerMiddleware\Zed\Process\Business\Mapper\Map\MapInterface;
use SprykerMiddleware\Zed\Process\Business\Translator\Dictionary\DictionaryInterface;
use SprykerMiddleware\Zed\Process\Business\Validator\ValidationRuleSet\ValidationRuleSetInterface;

class CompanyUserMiddlewareConnectorBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \SprykerMiddleware\Zed\Process\Business\Validator\ValidationRuleSet\ValidationRuleSetInterface
     */
    public function createCompanyUserValidationRuleSet(): ValidationRuleSetInterface
    {
        return new CompanyUserValidationRuleSet();
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Business\Mapper\Map\MapInterface
     */
    public function createCompanyUserMap(): MapInterface
    {
        return new CompanyUserMap();
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Business\Translator\Dictionary\DictionaryInterface
     */
    public function createCompanyUserDictionary(): DictionaryInterface
    {
        return new CompanyUserDictionary();
    }

    /**
     * @return \Pyz\Zed\Process\Business\Importer\ImporterInterface
     */
    public function createCompanyUserImporter(): ImporterInterface
    {
        return new Importer(
            $this->createDataImporterPublisher(),
            $this->createCompanyUserImportDataSetStepBroker(),
            $this->createDataSet()
        );
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\Publisher\DataImporterPublisherInterface
     */
    protected function createDataImporterPublisher(): DataImporterPublisherInterface
    {
        return new DataImporterPublisher();
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface
     */
    protected function createDataSet(): DataSetInterface
    {
        return new DataSet();
    }

    /**
     * @return \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerInterface
     */
    protected function createCompanyUserImportDataSetStepBroker(): DataSetStepBrokerInterface
    {
        $dataSetStepBroker = new DataSetStepBroker();

        $dataSetStepBroker->addStep($this->createCompanyUserWriteStep());

        return $dataSetStepBroker;
    }

    /**
     * @return \Spryker\Zed\CompanyUserDataImport\Business\Model\CompanyUser\CompanyUserWriterStep
     */
    protected function createCompanyUserWriteStep(): CompanyUserWriterStep
    {
        return new CompanyUserWriterStep();
    }
}
