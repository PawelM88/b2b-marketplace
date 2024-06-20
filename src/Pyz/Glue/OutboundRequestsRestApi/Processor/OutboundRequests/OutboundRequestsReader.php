<?php

namespace Pyz\Glue\OutboundRequestsRestApi\Processor\OutboundRequests;

use Pyz\Client\OutboundRequest\OutboundRequestClientInterface;
use Pyz\Glue\OutboundRequestsRestApi\OutboundRequestsRestApiConfig;
use Pyz\Glue\OutboundRequestsRestApi\Processor\Mapper\OutboundRequestsResourceMapper;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Generated\Shared\Transfer\OutboundRequestTransfer;

class OutboundRequestsReader implements OutboundRequestsReaderInterface
{
    /** @var \Pyz\Client\OutboundRequest\OutboundRequestClientInterface */
    private OutboundRequestClientInterface $outboundRequestClient;

    /** @var \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface */
    private RestResourceBuilderInterface $restResourceBuilder;

    /** @var \Pyz\Glue\OutboundRequestsRestApi\Processor\Mapper\OutboundRequestsResourceMapper */
    private OutboundRequestsResourceMapper $outboundRequestsResourceMapper;

    /**
     * @param \Pyz\Client\OutboundRequest\OutboundRequestClientInterface $outboundRequestClient
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     * @param \Pyz\Glue\OutboundRequestsRestApi\Processor\Mapper\OutboundRequestsResourceMapper $outboundRequestsResourceMapper
     */
    public function __construct(
        OutboundRequestClientInterface $outboundRequestClient,
        RestResourceBuilderInterface $restResourceBuilder,
        OutboundRequestsResourceMapper $outboundRequestsResourceMapper
    ) {
        $this->outboundRequestClient = $outboundRequestClient;
        $this->restResourceBuilder = $restResourceBuilder;
        $this->outboundRequestsResourceMapper = $outboundRequestsResourceMapper;
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function getOutboundRequestsSearchData(RestRequestInterface $restRequest): RestResponseInterface
    {
        $restResponse = $this->restResourceBuilder->createRestResponse();

        $outboundRequestTransfers = $this->outboundRequestClient->callOutboundRequest(
            (new OutboundRequestTransfer())->setMethod('GET')
        );

        foreach ($outboundRequestTransfers->getData() as $outboundResponseTransfer) {
            $restResource = $this->restResourceBuilder->createRestResource(
                OutboundRequestsRestApiConfig::RESOURCE_OUTBOUND_REQUESTS,
                $outboundResponseTransfer->getId()
                ,
                $this->outboundRequestsResourceMapper->mapOutboundRequestDataToOutboundRequestRestAttributes(
                    $outboundResponseTransfer->toArray()
                )
            );
            $restResponse->addResource($restResource);
        }
        return $restResponse;
    }
}
