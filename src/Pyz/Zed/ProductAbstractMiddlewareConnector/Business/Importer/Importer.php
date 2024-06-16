<?php

declare(strict_types=1);

namespace Pyz\Zed\ProductAbstractMiddlewareConnector\Business\Importer;

use Pyz\Zed\Process\Business\Importer\ImporterInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerInterface;
use Spryker\Zed\DataImport\Business\Model\Publisher\DataImporterPublisherInterface;
use Spryker\Zed\EventBehavior\EventBehaviorConfig;

class Importer implements ImporterInterface
{
    /**
     * @param \Spryker\Zed\DataImport\Business\Model\Publisher\DataImporterPublisherInterface $dataImporterPublisher
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerInterface $dataSetStepBroker
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     */
    public function __construct(
        protected DataImporterPublisherInterface $dataImporterPublisher,
        protected DataSetStepBrokerInterface $dataSetStepBroker,
        protected DataSetInterface $dataSet,
    ) {
    }

    /**
     * @param array<mixed> $data
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
