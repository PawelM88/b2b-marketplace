<?php

namespace Pyz\Glue\OutboundRequestsRestApi;

use Pyz\Client\OutboundRequest\OutboundRequestClientInterface;
use Pyz\Glue\OutboundRequestsRestApi\Processor\Mapper\OutboundRequestsResourceMapper;
use Pyz\Glue\OutboundRequestsRestApi\Processor\Mapper\OutboundRequestsResourceMapperInterface;
use Pyz\Glue\OutboundRequestsRestApi\Processor\OutboundRequests\OutboundRequestsReader;
use Pyz\Glue\OutboundRequestsRestApi\Processor\OutboundRequests\OutboundRequestsReaderInterface;
use Spryker\Glue\Kernel\AbstractFactory;

class OutboundRequestsRestApiFactory extends AbstractFactory
{
    /**
     * @throws \Spryker\Glue\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Glue\OutboundRequestsRestApi\Processor\OutboundRequests\OutboundRequestsReader
     */
    public function createOutboundRequestsReader(): OutboundRequestsReaderInterface
    {
        return new OutboundRequestsReader(
            $this->getOutboundRequestsClient(),
            $this->getResourceBuilder(),
            $this->createOutboundRequestsResourceMapper()
        );
    }

    /**
     * @throws \Spryker\Glue\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Client\OutboundRequest\OutboundRequestClient
     */
    public function getOutboundRequestsClient(): OutboundRequestClientInterface
    {
        return $this->getProvidedDependency(OutboundRequestsRestApiDependencyProvider::CLIENT_OUTBOUND_REQUEST);
    }

    /**
     * @return \Pyz\Glue\OutboundRequestsRestApi\Processor\Mapper\OutboundRequestsResourceMapper
     */
    public function createOutboundRequestsResourceMapper(): OutboundRequestsResourceMapperInterface
    {
        return new OutboundRequestsResourceMapper();
    }
}
