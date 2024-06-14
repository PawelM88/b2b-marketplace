<?php

declare(strict_types=1);

namespace Pyz\Zed\MerchantPaymentCommission\Communication\Plugin\Merchant;

use Generated\Shared\Transfer\MerchantResponseTransfer;
use Generated\Shared\Transfer\MerchantTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\MerchantExtension\Dependency\Plugin\MerchantPostUpdatePluginInterface;

/**
 * @method \Pyz\Zed\MerchantPaymentCommission\Business\MerchantPaymentCommissionFacadeInterface getFacade()
 * @method \Pyz\Zed\MerchantPaymentCommission\MerchantPaymentCommissionConfig getConfig()
 */
class MerchantPaymentCommissionMerchantPostUpdatePlugin extends AbstractPlugin implements
    MerchantPostUpdatePluginInterface
{
    /**
     * {@inheritDoc}
     * - Saves merchant payment commissions after the merchant is updated.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MerchantTransfer $merchantTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantResponseTransfer
     */
    public function postUpdate(MerchantTransfer $merchantTransfer): MerchantResponseTransfer
    {
        return $this->getFacade()->postUpdateMerchantPaymentCommission($merchantTransfer);
    }
}
