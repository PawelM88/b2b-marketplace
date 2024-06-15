<?php

declare(strict_types=1);

namespace Pyz\Client\MerchantPage;

use Pyz\Client\MerchantPage\Zed\MerchantPageZedStub;
use Pyz\Client\MerchantPage\Zed\MerchantPageZedStubInterface;
use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;

class MerchantPageFactory extends AbstractFactory
{
    /**
     * @throws \Spryker\Client\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Client\MerchantPage\Zed\MerchantPageZedStubInterface
     */
    public function createMerchantPageZedStub(): MerchantPageZedStubInterface
    {
        return new MerchantPageZedStub($this->getZedRequestClient());
    }

    /**
     * @throws \Spryker\Client\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected function getZedRequestClient(): ZedRequestClientInterface
    {
        return $this->getProvidedDependency(MerchantPageDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
