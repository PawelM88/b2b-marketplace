<?php

declare(strict_types=1);

namespace PyzTest\Zed\MerchantPaymentCommission\Helper;

use Codeception\Module;
use Generated\Shared\DataBuilder\MerchantPaymentCommissionBuilder;
use Generated\Shared\DataBuilder\MerchantPaymentCommissionPerStoreBuilder;
use Generated\Shared\DataBuilder\MerchantPaymentCommissionValuesBuilder;
use Generated\Shared\Transfer\MerchantPaymentCommissionPerStoreTransfer;
use Generated\Shared\Transfer\MerchantPaymentCommissionTransfer;
use Generated\Shared\Transfer\MerchantPaymentCommissionValuesTransfer;
use Generated\Shared\Transfer\MerchantTransfer;
use SprykerTest\Shared\Testify\Helper\LocatorHelperTrait;

class MerchantPaymentCommissionHelper extends Module
{
    use LocatorHelperTrait;

    /**
     * @param \Generated\Shared\Transfer\MerchantTransfer $merchantTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantPaymentCommissionTransfer
     */
    public function getMerchantPaymentCommissionTransfer(MerchantTransfer $merchantTransfer
    ): MerchantPaymentCommissionTransfer {
        $stores = $this->getStores();
        $idMerchant = $merchantTransfer->getIdMerchant();
        $merchantPaymentCommissionTransfer = (new MerchantPaymentCommissionBuilder())->build();
        $merchantPaymentCommissionTransfer->setFkMerchant($idMerchant);

        foreach ($stores as $store) {
            $storeName = $store->getName();

            $merchantPaymentCommissionPerStore = $this->addMerchantPaymentCommissionPerStoreByStoreName(
                $idMerchant,
                $storeName
            );

            $merchantPaymentCommissionPerStoreTransfer[] = $merchantPaymentCommissionPerStore;

            $merchantPaymentCommissionTransfer->setMerchantPaymentCommissionPerStore(
                $merchantPaymentCommissionPerStoreTransfer
            );
        }

        return $merchantPaymentCommissionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantTransfer $merchantTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantPaymentCommissionValuesTransfer
     */
    public function getMerchantPaymentCommissionValuesTransfer(MerchantTransfer $merchantTransfer
    ): MerchantPaymentCommissionValuesTransfer {
        $merchantPaymentCommissionValuesTransfer = (new MerchantPaymentCommissionValuesBuilder())->build();
        $merchantPaymentCommissionValuesTransfer->setFkMerchant($merchantTransfer->getIdMerchant());

        return $merchantPaymentCommissionValuesTransfer;
    }

    /**
     * @return int
     */
    public function getStoresNumber(): int
    {
        $stores = $this->getStores();
        return count($stores);
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantPaymentCommissionTransfer $merchantPaymentCommissionTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantPaymentCommissionTransfer
     */
    public function getFkStore(MerchantPaymentCommissionTransfer $merchantPaymentCommissionTransfer
    ): MerchantPaymentCommissionTransfer {
        $merchantPaymentCommissionsPerStoreTransfer = $merchantPaymentCommissionTransfer->getMerchantPaymentCommissionPerStore(
        );

        foreach ($merchantPaymentCommissionsPerStoreTransfer as $merchantPaymentCommissionPerStoreTransfer) {
            $merchantPaymentCommissionValue = $merchantPaymentCommissionPerStoreTransfer->getMerchantPaymentCommissionValues(
            );
            $storeId = $this->getStoreIdByName($merchantPaymentCommissionValue->getStoreName());
            $merchantPaymentCommissionValue->setFkStore($storeId);

            $merchantPaymentCommissionPerStoreTransfer->setMerchantPaymentCommissionValues(
                $merchantPaymentCommissionValue
            );
        }

        return $merchantPaymentCommissionTransfer->setMerchantPaymentCommissionPerStore(
            $merchantPaymentCommissionsPerStoreTransfer
        );
    }

    /**
     * @param int $idMerchant
     * @param string $storeName
     *
     * @return \Generated\Shared\Transfer\MerchantPaymentCommissionPerStoreTransfer
     */
    protected function addMerchantPaymentCommissionPerStoreByStoreName(
        int $idMerchant,
        string $storeName
    ): MerchantPaymentCommissionPerStoreTransfer {
        $merchantPaymentCommissionPerStore = (new MerchantPaymentCommissionPerStoreBuilder())->build();
        $merchantPaymentCommissionValuesTransfer = (new MerchantPaymentCommissionValuesBuilder())->build();

        $merchantPaymentCommissionValuesTransfer->setFkMerchant($idMerchant);
        $merchantPaymentCommissionValuesTransfer->setGrPaymentCommissionKey(mt_rand(0, 100));
        $merchantPaymentCommissionValuesTransfer->setGrPaymentCommissionCapKey(mt_rand(0, 10000));
        $merchantPaymentCommissionValuesTransfer->setStoreName($storeName);

        return $merchantPaymentCommissionPerStore->setMerchantPaymentCommissionValues(
            $merchantPaymentCommissionValuesTransfer
        );
    }

    /**
     * @return array
     */
    protected function getStores(): array
    {
        return $this->getLocator()->store()->facade()->getAllStores();
    }

    /**
     * @param string $storeName
     *
     * @return int
     */
    protected function getStoreIdByName(string $storeName): int
    {
        $store = $this->getLocator()->store()->facade()->getStoreByName($storeName);
        return $store->getIdStore();
    }
}
