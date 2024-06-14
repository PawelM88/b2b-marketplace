<?php

declare(strict_types=1);

namespace Pyz\Zed\MerchantPaymentCommission\Persistence;

use Generated\Shared\Transfer\MerchantPaymentCommissionTransfer;
use Generated\Shared\Transfer\MerchantPaymentCommissionValuesTransfer;
use Orm\Zed\MerchantPaymentCommission\Persistence\PyzMerchantPaymentCommission;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \Pyz\Zed\MerchantPaymentCommission\Persistence\MerchantPaymentCommissionPersistenceFactory getFactory()
 */
class MerchantPaymentCommissionEntityManager extends AbstractEntityManager implements
    MerchantPaymentCommissionEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\MerchantPaymentCommissionTransfer $merchantPaymentCommissionTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantPaymentCommissionTransfer
     */
    public function create(MerchantPaymentCommissionTransfer $merchantPaymentCommissionTransfer): MerchantPaymentCommissionTransfer
    {
        return $this->saveMerchantPaymentCommission(
            $merchantPaymentCommissionTransfer,
            new PyzMerchantPaymentCommission(),
        );
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantPaymentCommissionValuesTransfer $merchantPaymentCommissionValues
     *
     * @return \Generated\Shared\Transfer\MerchantPaymentCommissionValuesTransfer
     */
    public function update(MerchantPaymentCommissionValuesTransfer $merchantPaymentCommissionValues): MerchantPaymentCommissionValuesTransfer
    {
        $fkMerchant = $merchantPaymentCommissionValues->getFkMerchant();
        $fkStore = $merchantPaymentCommissionValues->getFkStore();

        if (!$fkStore) {
            $fkStore = $this->getStoreIdByName($merchantPaymentCommissionValues->getStoreName());
            $merchantPaymentCommissionValues->setFkStore($fkStore);
        }

        $merchantPaymentCommissionEntity = $this->getFactory()
            ->createMerchantPaymentCommissionQuery()
            ->filterByFkMerchant($fkMerchant)
            ->filterByFkStore($fkStore)
            ->findOne();

        if ($merchantPaymentCommissionEntity === null) {
            $merchantPaymentCommissionTransfer = new MerchantPaymentCommissionTransfer();
            $merchantPaymentCommissionTransfer = $this->getFactory()
                ->createPropelMerchantPaymentCommissionMapper(
                )->mapMerchantPaymentCommissionValuesTransferToMerchantPaymentCommissionTransfer(
                    $merchantPaymentCommissionValues,
                    $merchantPaymentCommissionTransfer,
                );

            $this->create($merchantPaymentCommissionTransfer);
        }

        if ($merchantPaymentCommissionEntity) {
            $this->updateMerchantPaymentCommission(
                $merchantPaymentCommissionValues,
                $merchantPaymentCommissionEntity,
            );
        }

        return $merchantPaymentCommissionValues;
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantPaymentCommissionTransfer $merchantPaymentCommissionTransfer
     * @param \Orm\Zed\MerchantPaymentCommission\Persistence\PyzMerchantPaymentCommission $merchantPaymentCommissionEntity
     *
     * @return \Generated\Shared\Transfer\MerchantPaymentCommissionTransfer
     */
    protected function saveMerchantPaymentCommission(
        MerchantPaymentCommissionTransfer $merchantPaymentCommissionTransfer,
        PyzMerchantPaymentCommission $merchantPaymentCommissionEntity,
    ): MerchantPaymentCommissionTransfer {
        $storeId = $this->getStoreIdByName($merchantPaymentCommissionTransfer->getStoreName());
        $merchantPaymentCommissionTransfer->setFkStore($storeId);

        $merchantPaymentCommissionEntity = $this->getFactory()
            ->createPropelMerchantPaymentCommissionMapper()
            ->mapMerchantPaymentCommissionTransferToMerchantPaymentCommissionEntity(
                $merchantPaymentCommissionTransfer,
                $merchantPaymentCommissionEntity,
            );

        $merchantPaymentCommissionEntity->save();

        $merchantPaymentCommissionTransfer->setIdMerchantPaymentCommission($merchantPaymentCommissionEntity->getIdMerchantPaymentCommission());

        return $merchantPaymentCommissionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantPaymentCommissionValuesTransfer $merchantPaymentCommissionValuesTransfer
     * @param \Orm\Zed\MerchantPaymentCommission\Persistence\PyzMerchantPaymentCommission $merchantPaymentCommissionEntity
     *
     * @return \Generated\Shared\Transfer\MerchantPaymentCommissionValuesTransfer
     */
    protected function updateMerchantPaymentCommission(
        MerchantPaymentCommissionValuesTransfer $merchantPaymentCommissionValuesTransfer,
        PyzMerchantPaymentCommission $merchantPaymentCommissionEntity,
    ): MerchantPaymentCommissionValuesTransfer {
        $merchantPaymentCommissionEntity = $this->getFactory()
            ->createPropelMerchantPaymentCommissionMapper()
            ->mapMerchantPaymentCommissionValuesTransferToMerchantPaymentCommissionEntity(
                $merchantPaymentCommissionValuesTransfer,
                $merchantPaymentCommissionEntity,
            );

        $merchantPaymentCommissionEntity->save();

        $merchantPaymentCommissionValuesTransfer->setIdMerchantPaymentCommission($merchantPaymentCommissionEntity->getIdMerchantPaymentCommission());

        return $merchantPaymentCommissionValuesTransfer;
    }

    /**
     * @param string $storeName
     *
     * @return int
     */
    private function getStoreIdByName(string $storeName): int
    {
        $store = $this->getFactory()->getStoreFacade()->getStoreByName($storeName);

        return $store->getIdStore();
    }
}
