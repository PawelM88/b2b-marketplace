<?php

declare(strict_types=1);

namespace Pyz\Zed\MerchantPaymentCommission\Communication\Plugin\Merchant;

use Generated\Shared\Transfer\MerchantPaymentCommissionTransfer;
use Generated\Shared\Transfer\MerchantResponseTransfer;
use Generated\Shared\Transfer\MerchantTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\MerchantExtension\Dependency\Plugin\MerchantPostCreatePluginInterface;

/**
 * @method \Pyz\Zed\MerchantPaymentCommission\Business\MerchantPaymentCommissionFacadeInterface getFacade()
 * @method \Pyz\Zed\MerchantPaymentCommission\MerchantPaymentCommissionConfig getConfig()
 */
class MerchantPaymentCommissionPostCreatePlugin extends AbstractPlugin implements MerchantPostCreatePluginInterface
{
    /**
     * {@inheritDoc}
     * - Saves merchant payment commissions after the merchant is created.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MerchantTransfer $merchantTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantResponseTransfer
     */
    public function postCreate(MerchantTransfer $merchantTransfer): MerchantResponseTransfer
    {
        if (!$merchantTransfer->getMerchantPaymentCommission()) {
            $merchantTransfer->setMerchantPaymentCommission(new MerchantPaymentCommissionTransfer());
        }

        $merchantPaymentCommissionTransfer = $merchantTransfer
            ->getMerchantPaymentCommission()
            ->setFkMerchant($merchantTransfer->getIdMerchant());

        $merchantPaymentCommissionTransfer = $this->getFacade()->createMerchantPaymentCommission(
            $merchantPaymentCommissionTransfer,
        );

        $merchantTransfer->setMerchantPaymentCommission($merchantPaymentCommissionTransfer);

        return (new MerchantResponseTransfer())
            ->setIsSuccess(true)
            ->setMerchant($merchantTransfer);
    }
}
