<?php

declare(strict_types=1);

namespace Pyz\Zed\MerchantPage\Business;

use Pyz\Zed\MerchantPage\Business\Mail\MailHandler;
use Pyz\Zed\MerchantPage\Business\Merchant\MerchantFinder;
use Pyz\Zed\MerchantPage\Business\Merchant\MerchantFinderInterface;
use Pyz\Zed\MerchantPage\MerchantPageDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\Mail\Business\MailFacadeInterface;
use Spryker\Zed\MerchantProfile\Business\MerchantProfileFacadeInterface;

/**
 * @method \Pyz\Zed\MerchantPage\MerchantPageConfig getConfig()
 */
class MerchantPageBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Zed\MerchantPage\Business\Mail\MailHandler
     */
    public function createMailHandler(): MailHandler
    {
        return new MailHandler($this->getSprykerMailFacade());
    }

    /**
     * Returns an instance of the provided mail facade
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Spryker\Zed\Mail\Business\MailFacadeInterface
     */
    protected function getSprykerMailFacade(): MailFacadeInterface
    {
        return $this->getProvidedDependency(MerchantPageDependencyProvider::SPRYKER_FACADE_MAIL);
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Zed\MerchantPage\Business\Merchant\MerchantFinderInterface
     */
    public function createMerchantFinder(): MerchantFinderInterface
    {
        return new MerchantFinder($this->getSprykerMerchantProfileFacade());
    }

    /**
     * Returns an instance of the provided merchant profile facade
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Spryker\Zed\MerchantProfile\Business\MerchantProfileFacadeInterface
     */
    protected function getSprykerMerchantProfileFacade(): MerchantProfileFacadeInterface
    {
        return $this->getProvidedDependency(MerchantPageDependencyProvider::SPRYKER_FACADE_MERCHANT_PROFILE);
    }
}
