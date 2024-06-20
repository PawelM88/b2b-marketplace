<?php

namespace Pyz\Client\OutboundRequest;

use Pyz\Client\OutboundRequest\Zed\OutboundRequestZedStubInterface;
use Pyz\Client\OutboundRequest\Zed\OutboundRequestZedStub;
use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;

class OutboundRequestFactory extends AbstractFactory
{
    /**
     * @throws \Spryker\Client\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Client\OutboundRequest\OutboundRequestZedStubInterface
     */
    public function createOutboundRequestZedStub(): OutboundRequestZedStubInterface
    {
        return new OutboundRequestZedStub($this->getZedRequestClient());
    }

    /**
     * @throws \Spryker\Client\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Spryker\Client\ZedRequest\ZedRequestClientInterface
     */
    protected function getZedRequestClient(): ZedRequestClientInterface
    {
        return $this->getProvidedDependency(OutboundRequestDependencyProvider::CLIENT_ZED_REQUEST);
    }
}
