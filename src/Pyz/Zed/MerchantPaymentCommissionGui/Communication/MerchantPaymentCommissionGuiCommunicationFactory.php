<?php

declare(strict_types=1);

namespace Pyz\Zed\MerchantPaymentCommissionGui\Communication;

use Pyz\Zed\MerchantPaymentCommissionGui\Communication\Form\DataProvider\MerchantPaymentCommissionFormDataProvider;
use Pyz\Zed\MerchantPaymentCommissionGui\MerchantPaymentCommissionGuiDependencyProvider;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Spryker\Zed\Store\Business\StoreFacadeInterface;

class MerchantPaymentCommissionGuiCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \Pyz\Zed\MerchantPaymentCommissionGui\Communication\Form\DataProvider\MerchantPaymentCommissionFormDataProvider
     */
    public function createMerchantPaymentCommissionFormDataProvider(): MerchantPaymentCommissionFormDataProvider
    {
        return new MerchantPaymentCommissionFormDataProvider(
            $this->getStoreFacade(),
        );
    }

    /**
     * @return \Spryker\Zed\Store\Business\StoreFacadeInterface
     */
    public function getStoreFacade(): StoreFacadeInterface
    {
        return $this->getProvidedDependency(MerchantPaymentCommissionGuiDependencyProvider::FACADE_STORE);
    }
}
