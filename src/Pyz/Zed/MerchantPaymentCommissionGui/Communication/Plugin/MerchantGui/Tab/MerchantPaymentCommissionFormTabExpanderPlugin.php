<?php

declare(strict_types=1);

namespace Pyz\Zed\MerchantPaymentCommissionGui\Communication\Plugin\MerchantGui\Tab;

use Generated\Shared\Transfer\TabItemTransfer;
use Generated\Shared\Transfer\TabsViewTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\MerchantGuiExtension\Dependency\Plugin\MerchantFormTabExpanderPluginInterface;

/**
 * @method \Pyz\Zed\MerchantPaymentCommissionGui\Communication\MerchantPaymentCommissionGuiCommunicationFactory getFactory()
 */
class MerchantPaymentCommissionFormTabExpanderPlugin extends AbstractPlugin implements
    MerchantFormTabExpanderPluginInterface
{
    /**
     * {@inheritDoc}
     *
     * @param \Generated\Shared\Transfer\TabsViewTransfer $tabsViewTransfer
     *
     * @return \Generated\Shared\Transfer\TabsViewTransfer
     */
    public function expand(TabsViewTransfer $tabsViewTransfer): TabsViewTransfer
    {
        $tabItemTransfer = (new TabItemTransfer())->setName('merchant-payment-commission')
            ->setTitle('Payment Commission')
            ->setTemplate('@MerchantPaymentCommissionGui/_partials/merchant-payment-commission-tab.twig');

        $tabsViewTransfer->addTab($tabItemTransfer);

        return $tabsViewTransfer;
    }
}
