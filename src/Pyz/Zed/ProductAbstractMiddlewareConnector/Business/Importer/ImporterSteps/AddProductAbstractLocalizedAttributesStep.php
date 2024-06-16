<?php

declare(strict_types=1);

namespace Pyz\Zed\ProductAbstractMiddlewareConnector\Business\Importer\ImporterSteps;

use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

class AddProductAbstractLocalizedAttributesStep implements DataImportStepInterface
{
    /**
     * @var string
     */
    public const KEY_LOCALES = 'locales';

    /**
     * @var array<string>
     */
    public const LOCALIZED_KEYS = [
        'name',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'url',
    ];

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet): void
    {
        $this->addDataSetLocalizedValues($dataSet);
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    protected function addDataSetLocalizedValues(DataSetInterface $dataSet): void
    {
        foreach (self::LOCALIZED_KEYS as $key) {
            if ($dataSet[$key]) {
                $this->addDataSetLocalizedValuesByKey($dataSet, $key);
            }
        }
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     * @param string $key
     *
     * @return void
     */
    protected function addDataSetLocalizedValuesByKey(DataSetInterface $dataSet, string $key): void
    {
        foreach ($dataSet[self::KEY_LOCALES] as $localeKey => $localeValue) {
            if (array_key_exists($localeKey, $dataSet[$key])) {
                $dataSet[$key . '.' . $localeKey] = $dataSet[$key][$localeKey];
            }
        }
    }
}
