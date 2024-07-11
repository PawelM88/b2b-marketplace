<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Yves\CustomerPage;

use Pyz\Yves\CustomerPage\Form\FormFactory;
use Pyz\Yves\CustomerPage\Plugin\TermHandler;
use Spryker\Client\CmsStorage\CmsStorageClientInterface;
use Spryker\Client\Session\SessionClientInterface;
use Spryker\Client\Store\StoreClientInterface;
use SprykerShop\Yves\CustomerPage\CustomerPageFactory as SprykerCustomerPageFactory;

class CustomerPageFactory extends SprykerCustomerPageFactory
{
    /**
     * @throws \Spryker\Yves\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Spryker\Client\Session\SessionClientInterface
     */
    public function getSessionClient(): SessionClientInterface
    {
        return $this->getProvidedDependency(CustomerPageDependencyProvider::CLIENT_SESSION);
    }

    /**
     * @return \Pyz\Yves\CustomerPage\Form\FormFactory
     */
    public function createCustomerFormFactory(): FormFactory
    {
        return new FormFactory();
    }

    /**
     * @throws \Spryker\Yves\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Yves\CustomerPage\Plugin\TermHandler
     */
    public function getTermHandler(): TermHandler
    {
        return new TermHandler(
            $this->getCmsStorageClient(),
            $this->getCmsStoreClient(),
        );
    }

    /**
     * @throws \Spryker\Yves\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Spryker\Client\CmsStorage\CmsStorageClientInterface
     */
    protected function getCmsStorageClient(): CmsStorageClientInterface
    {
        return $this->getProvidedDependency(CustomerPageDependencyProvider::CLIENT_CMS_STORAGE);
    }

    /**
     * @throws \Spryker\Yves\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Spryker\Client\Store\StoreClientInterface
     */
    protected function getCmsStoreClient(): StoreClientInterface
    {
        return $this->getProvidedDependency(CustomerPageDependencyProvider::CLIENT_CMS_STORE);
    }
}
