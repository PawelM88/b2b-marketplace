<?php

declare(strict_types=1);

namespace Pyz\Zed\MerchantPaymentCommission\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\MerchantPaymentCommissionPerStoreTransfer;
use Generated\Shared\Transfer\MerchantPaymentCommissionTransfer;
use Generated\Shared\Transfer\MerchantPaymentCommissionValuesTransfer;
use Orm\Zed\MerchantPaymentCommission\Persistence\PyzMerchantPaymentCommission;

class MerchantPaymentCommissionMapper implements MerchantPaymentCommissionMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\MerchantPaymentCommissionTransfer $merchantPaymentCommissionTransfer
     * @param \Orm\Zed\MerchantPaymentCommission\Persistence\PyzMerchantPaymentCommission $merchantPaymentCommissionEntity
     *
     * @return \Orm\Zed\MerchantPaymentCommission\Persistence\PyzMerchantPaymentCommission
     */
    public function mapMerchantPaymentCommissionTransferToMerchantPaymentCommissionEntity(
        MerchantPaymentCommissionTransfer $merchantPaymentCommissionTransfer,
        PyzMerchantPaymentCommission $merchantPaymentCommissionEntity,
    ): PyzMerchantPaymentCommission {
        $merchantPaymentCommissionEntity->fromArray(
            $merchantPaymentCommissionTransfer->modifiedToArray(false),
        );

        return $merchantPaymentCommissionEntity;
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantPaymentCommissionValuesTransfer $merchantPaymentCommissionValuesTransfer
     * @param \Orm\Zed\MerchantPaymentCommission\Persistence\PyzMerchantPaymentCommission $merchantPaymentCommissionEntity
     *
     * @return \Orm\Zed\MerchantPaymentCommission\Persistence\PyzMerchantPaymentCommission
     */
    public function mapMerchantPaymentCommissionValuesTransferToMerchantPaymentCommissionEntity(
        MerchantPaymentCommissionValuesTransfer $merchantPaymentCommissionValuesTransfer,
        PyzMerchantPaymentCommission $merchantPaymentCommissionEntity,
    ): PyzMerchantPaymentCommission {
        $merchantPaymentCommissionEntity->fromArray(
            $merchantPaymentCommissionValuesTransfer->modifiedToArray(false),
        );

        return $merchantPaymentCommissionEntity;
    }

    /**
     * @param \Orm\Zed\MerchantPaymentCommission\Persistence\PyzMerchantPaymentCommission $merchantPaymentCommissionEntity
     * @param string $storeName
     *
     * @return \Generated\Shared\Transfer\MerchantPaymentCommissionPerStoreTransfer
     */
    public function mapMerchantPaymentCommissionEntityToMerchantPaymentCommissionValuesTransfer(
        PyzMerchantPaymentCommission $merchantPaymentCommissionEntity,
        string $storeName,
    ): MerchantPaymentCommissionPerStoreTransfer {
        $newMerchantPaymentCommissionValuesTransfer = new MerchantPaymentCommissionValuesTransfer();
        $newMerchantPaymentCommissionValuesTransfer->fromArray(
            $merchantPaymentCommissionEntity->toArray(),
            true,
        );

        $newMerchantPaymentCommissionValuesTransfer->setStoreName($storeName);

        $merchantPaymentCommissionPerStore = new MerchantPaymentCommissionPerStoreTransfer();
        $merchantPaymentCommissionPerStore->setMerchantPaymentCommissionValues(
            $newMerchantPaymentCommissionValuesTransfer,
        );

        return $merchantPaymentCommissionPerStore;
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantPaymentCommissionValuesTransfer $merchantPaymentCommissionValuesTransfer
     * @param \Generated\Shared\Transfer\MerchantPaymentCommissionTransfer $merchantPaymentCommissionTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantPaymentCommissionTransfer
     */
    public function mapMerchantPaymentCommissionValuesTransferToMerchantPaymentCommissionTransfer(
        MerchantPaymentCommissionValuesTransfer $merchantPaymentCommissionValuesTransfer,
        MerchantPaymentCommissionTransfer $merchantPaymentCommissionTransfer,
    ): MerchantPaymentCommissionTransfer {
        return $merchantPaymentCommissionTransfer->fromArray($merchantPaymentCommissionValuesTransfer->toArray());
    }
}
