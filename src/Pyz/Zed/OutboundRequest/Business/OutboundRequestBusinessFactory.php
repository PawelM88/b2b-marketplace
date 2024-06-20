<?php

namespace Pyz\Zed\OutboundRequest\Business;

use GuzzleHttp\ClientInterface;
use Pyz\Zed\OutboundRequest\Business\Mapper\OutboundRequestMapper;
use Pyz\Zed\OutboundRequest\Business\Mapper\OutboundRequestMapperInterface;
use Pyz\Zed\OutboundRequest\Business\OutboundRequest\OutboundRequestReader;
use Pyz\Zed\OutboundRequest\Business\OutboundRequest\OutboundRequestReaderInterface;
use Pyz\Zed\OutboundRequest\OutboundRequestDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Pyz\Zed\OutboundRequest\OutboundRequestConfig getConfig()
 */
class OutboundRequestBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Zed\OutboundRequest\Business\OutboundRequest\OutboundRequestReaderInterface
     */
    public function createOutboundRequestReader(): OutboundRequestReaderInterface
    {
        return new OutboundRequestReader(
            $this->getConfig(),
            $this->getGuzzleHttpClient(),
            $this->createOutboundRequestMapper()
        );
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \GuzzleHttp\ClientInterface
     */
    private function getGuzzleHttpClient(): ClientInterface
    {
        return $this->getProvidedDependency(OutboundRequestDependencyProvider::GUZZLE_HTTP_CLIENT);
    }

    /**
     * @return \Pyz\Zed\OutboundRequest\Business\Mapper\OutboundRequestMapper
     */
    public function createOutboundRequestMapper(): OutboundRequestMapperInterface
    {
        return new OutboundRequestMapper();
    }
}
