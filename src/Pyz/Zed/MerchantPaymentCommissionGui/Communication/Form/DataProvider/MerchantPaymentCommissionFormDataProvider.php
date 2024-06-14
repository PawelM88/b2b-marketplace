<?php

declare(strict_types=1);

namespace Pyz\Zed\MerchantPaymentCommissionGui\Communication\Form\DataProvider;

use Generated\Shared\Transfer\MerchantPaymentCommissionPerStoreTransfer;
use Generated\Shared\Transfer\MerchantPaymentCommissionTransfer;
use Generated\Shared\Transfer\MerchantPaymentCommissionValuesTransfer;
use Spryker\Zed\Store\Business\StoreFacadeInterface as SprykerStoreFacadeInterface;

class MerchantPaymentCommissionFormDataProvider
{
    /**
     * @var \Spryker\Zed\Store\Business\StoreFacadeInterface
     */
    protected SprykerStoreFacadeInterface $storeFacade;

    /**
     * @param \Spryker\Zed\Store\Business\StoreFacadeInterface $storeFacade
     */
    public function __construct(SprykerStoreFacadeInterface $storeFacade)
    {
        $this->storeFacade = $storeFacade;
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantPaymentCommissionTransfer|null $merchantPaymentCommissionTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantPaymentCommissionTransfer
     */
    public function getData(?MerchantPaymentCommissionTransfer $merchantPaymentCommissionTransfer): MerchantPaymentCommissionTransfer
    {
        if ($merchantPaymentCommissionTransfer === null) {
            $merchantPaymentCommissionTransfer = new MerchantPaymentCommissionTransfer();
        }

        return $this->addPaymentCommissionPerStoreAttributes($merchantPaymentCommissionTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantPaymentCommissionTransfer $merchantPaymentCommissionTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantPaymentCommissionTransfer
     */
    protected function addPaymentCommissionPerStoreAttributes(
        MerchantPaymentCommissionTransfer $merchantPaymentCommissionTransfer,
    ): MerchantPaymentCommissionTransfer {
        $merchantPaymentCommissionPerStoreTransfer = [];

        if (!$merchantPaymentCommissionTransfer->getMerchantPaymentCommissionPerStore()) {
            $stores = $this->storeFacade->getAllStores();

            foreach ($stores as $store) {
                $storeName = $store->getName();

                $merchantPaymentCommissionPerStore = $this->addMerchantPaymentCommissionPerStoreByStoreName(
                    $merchantPaymentCommissionTransfer,
                    $storeName,
                );

                $merchantPaymentCommissionPerStoreTransfer[] = $merchantPaymentCommissionPerStore;

                $merchantPaymentCommissionTransfer->setMerchantPaymentCommissionPerStore($merchantPaymentCommissionPerStoreTransfer);
            }
        }

        return $merchantPaymentCommissionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantPaymentCommissionTransfer $merchantPaymentCommissionTransfer
     * @param string $storeName
     *
     * @return \Generated\Shared\Transfer\MerchantPaymentCommissionPerStoreTransfer
     */
    protected function addMerchantPaymentCommissionPerStoreByStoreName(
        MerchantPaymentCommissionTransfer $merchantPaymentCommissionTransfer,
        string $storeName,
    ): MerchantPaymentCommissionPerStoreTransfer {
        $merchantPaymentCommissionPerStoreTransfer = new MerchantPaymentCommissionPerStoreTransfer();
        $merchantPaymentCommissionPerStoreTransfer->setMerchantPaymentCommissionValues(
            $this->addMerchantPaymentCommissionValues($merchantPaymentCommissionTransfer, $storeName),
        );

        return $merchantPaymentCommissionPerStoreTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantPaymentCommissionTransfer $merchantPaymentCommissionTransfer
     * @param string $storeName
     *
     * @return \Generated\Shared\Transfer\MerchantPaymentCommissionValuesTransfer
     */
    protected function addMerchantPaymentCommissionValues(
        MerchantPaymentCommissionTransfer $merchantPaymentCommissionTransfer,
        string $storeName,
    ): MerchantPaymentCommissionValuesTransfer {
        $merchantPaymentCommissionValuesTransfer = new MerchantPaymentCommissionValuesTransfer();
        $merchantPaymentCommissionValuesTransfer->setStoreName($storeName);

        $merchantPaymentCommissionValuesData = $merchantPaymentCommissionValuesTransfer->toArray(true, true);
        $merchantPaymentCommissionData = $merchantPaymentCommissionTransfer->toArray(true, true);

        foreach ($merchantPaymentCommissionValuesData as $merchantPaymentCommissionPerStoreFieldName => $merchantPaymentCommissionValue) {
            $merchantPaymentCommissionKey = $merchantPaymentCommissionData[$merchantPaymentCommissionPerStoreFieldName];
            if (!$merchantPaymentCommissionKey) {
                continue;
            }

            $merchantPaymentCommissionValuesTransfer->fromArray($merchantPaymentCommissionValuesData);
        }

        return $merchantPaymentCommissionValuesTransfer;
    }
}
