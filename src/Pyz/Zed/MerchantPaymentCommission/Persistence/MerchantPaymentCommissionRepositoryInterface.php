<?php

namespace Pyz\Zed\MerchantPaymentCommission\Persistence;

use Generated\Shared\Transfer\MerchantPaymentCommissionValuesTransfer;

interface MerchantPaymentCommissionRepositoryInterface
{
    /**
     * @param \Generated\Shared\Transfer\MerchantPaymentCommissionValuesTransfer $merchantPaymentCommissionValues
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     * @throws \Spryker\Zed\Store\Business\Model\Exception\StoreNotFoundException
     *
     * @return array <mixed>
     */
    public function findMerchantPaymentCommissionsPerStore(
        MerchantPaymentCommissionValuesTransfer $merchantPaymentCommissionValues,
    ): array;
}
