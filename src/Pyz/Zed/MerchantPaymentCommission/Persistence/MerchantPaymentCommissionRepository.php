<?php

declare(strict_types=1);

namespace Pyz\Zed\MerchantPaymentCommission\Persistence;

use Generated\Shared\Transfer\MerchantPaymentCommissionValuesTransfer;
use Propel\Runtime\Collection\Collection;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \Pyz\Zed\MerchantPaymentCommission\Persistence\MerchantPaymentCommissionPersistenceFactory getFactory()
 */
class MerchantPaymentCommissionRepository extends AbstractRepository implements
    MerchantPaymentCommissionRepositoryInterface
{
    /**
     * @param \Generated\Shared\Transfer\MerchantPaymentCommissionValuesTransfer $merchantPaymentCommissionValues
     *
     * @return array <mixed>
     */
    public function findMerchantPaymentCommissionsPerStore(
        MerchantPaymentCommissionValuesTransfer $merchantPaymentCommissionValues,
    ): array {
        $merchantPaymentCommissionEntities = $this->getMerchantPaymentCommissionsByFkMerchant(
            $merchantPaymentCommissionValues,
        );

        return $this->getMerchantPaymentCommissionPerStore($merchantPaymentCommissionEntities);
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantPaymentCommissionValuesTransfer $merchantPaymentCommissionValues
     *
     * @return \Propel\Runtime\Collection\Collection
     */
    private function getMerchantPaymentCommissionsByFkMerchant(
        MerchantPaymentCommissionValuesTransfer $merchantPaymentCommissionValues,
    ): Collection {
        return $this->getFactory()
            ->createMerchantPaymentCommissionQuery()
            ->findByFkMerchant($merchantPaymentCommissionValues->getFkMerchant());
    }

    /**
     * @param \Propel\Runtime\Collection\Collection $merchantPaymentCommissionEntities
     *
     * @return array <mixed>
     */
    private function getMerchantPaymentCommissionPerStore(Collection $merchantPaymentCommissionEntities): array
    {
        $merchantPaymentCommissionsPerStore = [];

        foreach ($merchantPaymentCommissionEntities as $merchantPaymentCommissionEntity) {
            $merchantPaymentCommissionFkStore = $merchantPaymentCommissionEntity->getFkStore();

            if ($merchantPaymentCommissionFkStore) {
                $storeName = $this->getStoreNameByFkStore($merchantPaymentCommissionFkStore);

                $mappedMerchantPaymentCommission = $this->getFactory()
                    ->createPropelMerchantPaymentCommissionMapper()
                    ->mapMerchantPaymentCommissionEntityToMerchantPaymentCommissionValuesTransfer(
                        $merchantPaymentCommissionEntity,
                        $storeName,
                    );

                $merchantPaymentCommissionsPerStore[] = $mappedMerchantPaymentCommission;
            }
        }

        return $merchantPaymentCommissionsPerStore;
    }

    /**
     * @param int $merchantPaymentCommissionFkStore
     *
     * @return string
     */
    private function getStoreNameByFkStore(int $merchantPaymentCommissionFkStore): string
    {
        $store = $this->getFactory()->getStoreFacade()->getStoreById($merchantPaymentCommissionFkStore);

        return $store->getName();
    }
}
