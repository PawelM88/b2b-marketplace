<?php

namespace Pyz\Zed\MerchantPaymentCommission\Persistence;

use Generated\Shared\Transfer\MerchantPaymentCommissionTransfer;
use Generated\Shared\Transfer\MerchantPaymentCommissionValuesTransfer;

interface MerchantPaymentCommissionEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\MerchantPaymentCommissionTransfer $merchantPaymentCommissionTransfer
     *
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     *
     * @return \Generated\Shared\Transfer\MerchantPaymentCommissionTransfer
     */
    public function create(MerchantPaymentCommissionTransfer $merchantPaymentCommissionTransfer): MerchantPaymentCommissionTransfer;

    /**
     * @param \Generated\Shared\Transfer\MerchantPaymentCommissionValuesTransfer $merchantPaymentCommissionValues
     *
     * @throws \Propel\Runtime\Exception\PropelException
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException
     *
     * @return \Generated\Shared\Transfer\MerchantPaymentCommissionValuesTransfer
     */
    public function update(MerchantPaymentCommissionValuesTransfer $merchantPaymentCommissionValues): MerchantPaymentCommissionValuesTransfer;
}
