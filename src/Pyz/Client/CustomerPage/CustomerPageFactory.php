<?php

declare(strict_types=1);

namespace Pyz\Client\CustomerPage;

use Pyz\Client\CustomerPage\Zed\CustomerPageZedStub;
use Pyz\Client\CustomerPage\Zed\CustomerPageZedStubInterface;
use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;

class CustomerPageFactory extends AbstractFactory
{
    /**
     * @throws \Spryker\Client\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Client\CustomerPage\Zed\CustomerPageZedStubInterface
     */
    public function createCustomerPageZedStub(): CustomerPageZedStubInterface
    {
        return new CustomerPageZedStub($this->getZedRequestClient());
    }

    /**
     * @throws \Spryker\Client\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected function getZedRequestClient(): ZedRequestClientInterface
    {
        return $this->getProvidedDependency(CustomerPageDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
