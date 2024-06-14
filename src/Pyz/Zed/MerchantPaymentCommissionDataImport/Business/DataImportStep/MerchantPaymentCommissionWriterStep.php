<?php

declare(strict_types=1);

namespace Pyz\Zed\MerchantPaymentCommissionDataImport\Business\DataImportStep;

use Orm\Zed\Merchant\Persistence\SpyMerchantQuery;
use Orm\Zed\MerchantPaymentCommission\Persistence\PyzMerchantPaymentCommissionQuery;
use Orm\Zed\Store\Persistence\SpyStoreQuery;
use Pyz\Zed\DataImport\Business\Exception\EntityNotFoundException;
use Pyz\Zed\MerchantPaymentCommissionDataImport\Business\DataSet\MerchantPaymentCommissionDataSetInterface;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

class MerchantPaymentCommissionWriterStep implements DataImportStepInterface
{
    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet): void
    {
        $idMerchant = $this->getIdMerchantByReference($dataSet[MerchantPaymentCommissionDataSetInterface::COLUMN_MERCHANT_REFERENCE]);
        $idStore = $this->getIdStoreByName($dataSet[MerchantPaymentCommissionDataSetInterface::COLUMN_MERCHANT_STORE]);

        $merchantPaymentCommissionEntity = PyzMerchantPaymentCommissionQuery::create()
            ->filterByFkMerchant($idMerchant)
            ->filterByFkStore($idStore)
            ->findOneOrCreate();

        $merchantPaymentCommissionEntity->setGrPaymentCommissionKey(
            $dataSet[MerchantPaymentCommissionDataSetInterface::COLUMN_GR_PAYMENT_COMMISSION_KEY],
        );

        $merchantPaymentCommissionEntity->setGrPaymentCommissionCapKey(
            $dataSet[MerchantPaymentCommissionDataSetInterface::COLUMN_GR_PAYMENT_COMMISSION_CAP_KEY],
        );

        if ($merchantPaymentCommissionEntity->isNew() || $merchantPaymentCommissionEntity->isModified()) {
            $merchantPaymentCommissionEntity->save();
        }
    }

    /**
     * @param string $merchantReference
     *
     * @throws \Pyz\Zed\DataImport\Business\Exception\EntityNotFoundException
     *
     * @return int
     */
    protected function getIdMerchantByReference(string $merchantReference): int
    {
        $merchantEntity = SpyMerchantQuery::create()
            ->findOneByMerchantReference($merchantReference);

        if (!$merchantEntity) {
            throw new EntityNotFoundException(
                sprintf('Merchant with reference "%s" is not found.', $merchantReference),
            );
        }

        return $merchantEntity->getIdMerchant();
    }

    /**
     * @param string $storeName
     *
     * @throws \Pyz\Zed\DataImport\Business\Exception\EntityNotFoundException
     *
     * @return int
     */
    protected function getIdStoreByName(string $storeName): int
    {
        $storeEntity = SpyStoreQuery::create()->findOneByName($storeName);

        if (!$storeEntity->getIdStore()) {
            throw new EntityNotFoundException(
                sprintf('Store with name "%s" is not found.', $storeName),
            );
        }

        return $storeEntity->getIdStore();
    }
}
