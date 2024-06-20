<?php

namespace Pyz\Glue\OutboundRequestsRestApi\Controller;

use Spryker\Glue\Kernel\Controller\AbstractController;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

/**
 * @method \Pyz\Glue\OutboundRequestsRestApi\OutboundRequestsRestApiFactory getFactory()
 */
class OutboundRequestsResourceController extends AbstractController
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @throws \Spryker\Glue\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function getAction(RestRequestInterface $restRequest): RestResponseInterface
    {
        return $this->getFactory()
            ->createOutboundRequestsReader()
            ->getOutboundRequestsSearchData($restRequest);
    }
}
