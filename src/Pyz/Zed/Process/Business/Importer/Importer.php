<?php

namespace Pyz\Zed\Process\Business\Importer;

use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerInterface;
use Spryker\Zed\DataImport\Business\Model\Publisher\DataImporterPublisherInterface;
use Spryker\Zed\EventBehavior\EventBehaviorConfig;

class Importer implements ImporterInterface
{
    /**
     * @var \Spryker\Zed\DataImport\Business\Model\Publisher\DataImporterPublisherInterface
     */
    protected DataImporterPublisherInterface $dataImporterPublisher;

    /**
     * @var \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerInterface
     */
    private DataSetStepBrokerInterface $dataSetStepBroker;

    /**
     * @var \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface
     */
    private DataSetInterface $dataSet;

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\Publisher\DataImporterPublisherInterface $dataImporterPublisher
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerInterface $dataSetStepBroker
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     */
    public function __construct(
        DataImporterPublisherInterface $dataImporterPublisher,
        DataSetStepBrokerInterface $dataSetStepBroker,
        DataSetInterface $dataSet
    ) {
        $this->dataImporterPublisher = $dataImporterPublisher;
        $this->dataSetStepBroker = $dataSetStepBroker;
        $this->dataSet = $dataSet;
    }

    /**
     * @param array $data
     *
     * @return void
     */
    public function import(array $data): void
    {
        EventBehaviorConfig::disableEvent();
        foreach ($data as $item) {
            $this->dataSet->exchangeArray($item);
            $this->dataSetStepBroker->execute($this->dataSet);
        }

        EventBehaviorConfig::enableEvent();
        $this->dataImporterPublisher->triggerEvents();
    }
}
