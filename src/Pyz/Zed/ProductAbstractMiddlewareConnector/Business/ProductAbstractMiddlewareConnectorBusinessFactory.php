<?php

declare(strict_types=1);

namespace Pyz\Zed\ProductAbstractMiddlewareConnector\Business;

use Pyz\Zed\DataImport\Business\DataImportBusinessFactory;
use Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepository;
use Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepositoryInterface;
use Pyz\Zed\DataImport\Business\Model\ProductAbstract\ProductAbstractHydratorStep;
use Pyz\Zed\DataImport\Business\Model\ProductAbstract\ProductAbstractWriterStep;
use Pyz\Zed\Process\Business\Importer\ImporterInterface;
use Pyz\Zed\ProductAbstractMiddlewareConnector\Business\Importer\Importer;
use Pyz\Zed\ProductAbstractMiddlewareConnector\Business\Importer\ImporterSteps\AddProductAbstractLocalizedAttributesStep;
use Pyz\Zed\ProductAbstractMiddlewareConnector\Business\Mapper\Map\ProductAbstractMap;
use Pyz\Zed\ProductAbstractMiddlewareConnector\Business\Translator\Dictionary\ProductAbstractDictionary;
use Pyz\Zed\ProductAbstractMiddlewareConnector\Business\Validator\ValidationRuleSet\ProductAbstractValidationRuleSet;
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

class ProductAbstractMiddlewareConnectorBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \SprykerMiddleware\Zed\Process\Business\Validator\ValidationRuleSet\ValidationRuleSetInterface
     */
    public function createProductAbstractValidationRuleSet(): ValidationRuleSetInterface
    {
        return new ProductAbstractValidationRuleSet();
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Business\Mapper\Map\MapInterface
     */
    public function createProductAbstractMap(): MapInterface
    {
        return new ProductAbstractMap();
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Business\Translator\Dictionary\DictionaryInterface
     */
    public function createProductAbstractDictionary(): DictionaryInterface
    {
        return new ProductAbstractDictionary();
    }

    /**
     * @return \Pyz\Zed\Process\Business\Importer\ImporterInterface
     */
    public function createProductAbstractImporter(): ImporterInterface
    {
        return new Importer(
            $this->createDataImporterPublisher(),
            $this->createProductAbstractImportDataSetStepBroker(),
            $this->createDataSet(),
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
    protected function createProductAbstractImportDataSetStepBroker(): DataSetStepBrokerInterface
    {
        $dataSetStepBroker = new DataSetStepBroker();

        $dataImportBusinessFactory = $this->createDataImportBusinessFactory();

        $dataSetStepBroker
            ->addStep($dataImportBusinessFactory->createProductAbstractCheckExistenceStep())
            ->addStep($dataImportBusinessFactory->createAddLocalesStep())
            ->addStep($dataImportBusinessFactory->createAddCategoryKeysStep())
            ->addStep($this->createAddProductAbstractLocalizedAttributesStep())
            ->addStep($dataImportBusinessFactory->createTaxSetNameToIdTaxSetStep(ProductAbstractHydratorStep::COLUMN_TAX_SET_NAME))
            ->addStep($dataImportBusinessFactory->createAttributesExtractorStep())
            ->addStep($dataImportBusinessFactory->createProductLocalizedAttributesExtractorStep([
                ProductAbstractHydratorStep::COLUMN_NAME,
                ProductAbstractHydratorStep::COLUMN_URL,
                ProductAbstractHydratorStep::COLUMN_DESCRIPTION,
                ProductAbstractHydratorStep::COLUMN_META_TITLE,
                ProductAbstractHydratorStep::COLUMN_META_DESCRIPTION,
                ProductAbstractHydratorStep::COLUMN_META_KEYWORDS,
            ]))
            ->addStep(new ProductAbstractHydratorStep())
            ->addStep($this->createProductAbstractWriteStep());

        return $dataSetStepBroker;
    }

    /**
     * @return \Pyz\Zed\DataImport\Business\DataImportBusinessFactory
     */
    public function createDataImportBusinessFactory(): DataImportBusinessFactory
    {
        return new DataImportBusinessFactory();
    }

    /**
     * @return \Pyz\Zed\ProductAbstractMiddlewareConnector\Business\Importer\ImporterSteps\AddProductAbstractLocalizedAttributesStep
     */
    public function createAddProductAbstractLocalizedAttributesStep(): AddProductAbstractLocalizedAttributesStep
    {
        return new AddProductAbstractLocalizedAttributesStep();
    }

    /**
     * @return \Pyz\Zed\DataImport\Business\Model\ProductAbstract\ProductAbstractWriterStep
     */
    protected function createProductAbstractWriteStep(): ProductAbstractWriterStep
    {
        return new ProductAbstractWriterStep($this->createProductRepository());
    }

    /**
     * @return \Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepositoryInterface
     */
    protected function createProductRepository(): ProductRepositoryInterface
    {
        return new ProductRepository();
    }
}
