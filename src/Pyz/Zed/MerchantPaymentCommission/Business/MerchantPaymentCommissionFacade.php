<?php

declare(strict_types=1);

namespace Pyz\Zed\MerchantPaymentCommission\Business;

use Generated\Shared\Transfer\MerchantPaymentCommissionTransfer;
use Generated\Shared\Transfer\MerchantPaymentCommissionValuesTransfer;
use Generated\Shared\Transfer\MerchantResponseTransfer;
use Generated\Shared\Transfer\MerchantTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pyz\Zed\MerchantPaymentCommission\Business\MerchantPaymentCommissionBusinessFactory getFactory()
 * @method \Pyz\Zed\MerchantPaymentCommission\Persistence\MerchantPaymentCommissionRepositoryInterface getRepository()
 * @method \Pyz\Zed\MerchantPaymentCommission\Persistence\MerchantPaymentCommissionEntityManagerInterface getEntityManager()
 */
class MerchantPaymentCommissionFacade extends AbstractFacade implements MerchantPaymentCommissionFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\MerchantPaymentCommissionTransfer $merchantPaymentCommissionTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantPaymentCommissionTransfer
     */
    public function createMerchantPaymentCommission(MerchantPaymentCommissionTransfer $merchantPaymentCommissionTransfer): MerchantPaymentCommissionTransfer
    {
        return $this->getFactory()
            ->createMerchantPaymentCommissionWriter()
            ->createMerchantPaymentCommission($merchantPaymentCommissionTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantTransfer $merchantTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantResponseTransfer
     */
    public function postUpdateMerchantPaymentCommission(MerchantTransfer $merchantTransfer): MerchantResponseTransfer
    {
        return $this->getFactory()
            ->createMerchantPaymentCommissionWriter()
            ->postUpdateMerchantPaymentCommission($merchantTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantPaymentCommissionValuesTransfer $merchantPaymentCommissionValues
     *
     * @return array <mixed>
     */
    public function findMerchantPaymentCommissionsPerStore(MerchantPaymentCommissionValuesTransfer $merchantPaymentCommissionValues): array
    {
        return $this->getFactory()
            ->createMerchantPaymentCommissionReader()
            ->findMerchantPaymentCommissionsPerStore($merchantPaymentCommissionValues);
    }
}
