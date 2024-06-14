<?php

declare(strict_types=1);

namespace Pyz\Zed\MerchantPaymentCommission\Communication\Plugin\Merchant;

use Generated\Shared\Transfer\MerchantCollectionTransfer;
use Generated\Shared\Transfer\MerchantPaymentCommissionTransfer;
use Generated\Shared\Transfer\MerchantPaymentCommissionValuesTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\MerchantExtension\Dependency\Plugin\MerchantBulkExpanderPluginInterface;

/**
 * @method \Pyz\Zed\MerchantPaymentCommission\Business\MerchantPaymentCommissionFacadeInterface getFacade()
 * @method \Pyz\Zed\MerchantPaymentCommission\MerchantPaymentCommissionConfig getConfig()
 */
class MerchantPaymentCommissionExpanderPlugin extends AbstractPlugin implements MerchantBulkExpanderPluginInterface
{
    /**
     * {@inheritDoc}
     * - Expands merchant by merchant payment commissions data.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MerchantCollectionTransfer $merchantCollectionTransfer
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     * @throws \Spryker\Zed\Store\Business\Model\Exception\StoreNotFoundException
     *
     * @return \Generated\Shared\Transfer\MerchantCollectionTransfer
     */
    public function expand(MerchantCollectionTransfer $merchantCollectionTransfer): MerchantCollectionTransfer
    {
        $merchantPaymentCommissionValuesTransfer = $this->createMerchantPaymentCommissionValuesTransfer(
            $merchantCollectionTransfer,
        );

        $merchantPaymentCommissionsPerStore = $this->getFacade()->findMerchantPaymentCommissionsPerStore(
            $merchantPaymentCommissionValuesTransfer,
        );

        $merchantPaymentCommissionTransfer = $this->createMerchantPaymentCommissionTransfer(
            $merchantPaymentCommissionsPerStore,
        );

        foreach ($merchantCollectionTransfer->getMerchants() as $merchant) {
            $merchant->setMerchantPaymentCommission($merchantPaymentCommissionTransfer);
        }

        return $merchantCollectionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantCollectionTransfer $merchantCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantPaymentCommissionValuesTransfer
     */
    protected function createMerchantPaymentCommissionValuesTransfer(
        MerchantCollectionTransfer $merchantCollectionTransfer,
    ): MerchantPaymentCommissionValuesTransfer {
        $merchantPaymentCommissionValuesTransfer = new MerchantPaymentCommissionValuesTransfer();

        foreach ($merchantCollectionTransfer->getMerchants() as $merchant) {
            $merchantPaymentCommissionValuesTransfer->setFkMerchant($merchant->getIdMerchant());
        }

        return $merchantPaymentCommissionValuesTransfer;
    }

    /**
     * @param array<\Generated\Shared\Transfer\MerchantPaymentCommissionTransfer>$merchantPaymentCommissionsPerStore
     *
     * @return \Generated\Shared\Transfer\MerchantPaymentCommissionTransfer
     */
    protected function createMerchantPaymentCommissionTransfer(array $merchantPaymentCommissionsPerStore): MerchantPaymentCommissionTransfer
    {
        $merchantPaymentCommission = new MerchantPaymentCommissionTransfer();
        $merchantPaymentCommission->setMerchantPaymentCommissionPerStore($merchantPaymentCommissionsPerStore);

        return $merchantPaymentCommission;
    }
}
