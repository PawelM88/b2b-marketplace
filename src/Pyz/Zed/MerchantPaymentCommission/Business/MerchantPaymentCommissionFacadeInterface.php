<?php

namespace Pyz\Zed\MerchantPaymentCommission\Business;

use Generated\Shared\Transfer\MerchantPaymentCommissionTransfer;
use Generated\Shared\Transfer\MerchantPaymentCommissionValuesTransfer;
use Generated\Shared\Transfer\MerchantResponseTransfer;
use Generated\Shared\Transfer\MerchantTransfer;

interface MerchantPaymentCommissionFacadeInterface
{
    /**
     * Specification:
     * - Saves merchant payment commission attributes after the merchant is created.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MerchantPaymentCommissionTransfer $merchantPaymentCommissionTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantPaymentCommissionTransfer
     */
    public function createMerchantPaymentCommission(MerchantPaymentCommissionTransfer $merchantPaymentCommissionTransfer): MerchantPaymentCommissionTransfer;

    /**
     * Specification:
     * - Saves merchant payment commission after the merchant is updated.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MerchantTransfer $merchantTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantResponseTransfer
     */
    public function postUpdateMerchantPaymentCommission(MerchantTransfer $merchantTransfer): MerchantResponseTransfer;

    /**
     * Specification:
     * - Finds merchant payment commission per store by merchantId.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MerchantPaymentCommissionValuesTransfer $merchantPaymentCommissionValues
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     * @throws \Spryker\Zed\Store\Business\Model\Exception\StoreNotFoundException
     *
     * @return array <mixed>
     */
    public function findMerchantPaymentCommissionsPerStore(MerchantPaymentCommissionValuesTransfer $merchantPaymentCommissionValues): array;
}
