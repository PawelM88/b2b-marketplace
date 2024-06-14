<?php

namespace Pyz\Zed\MerchantPaymentCommission\Business\MerchantPaymentCommission;

use Generated\Shared\Transfer\MerchantPaymentCommissionValuesTransfer;

interface MerchantPaymentCommissionReaderInterface
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
