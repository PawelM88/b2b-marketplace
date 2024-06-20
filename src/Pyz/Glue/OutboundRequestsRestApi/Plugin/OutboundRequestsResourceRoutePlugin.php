<?php

namespace Pyz\Glue\OutboundRequestsRestApi\Plugin;

use Generated\Shared\Transfer\RestOutboundRequestResponseAttributesTransfer;
use Pyz\Glue\OutboundRequestsRestApi\OutboundRequestsRestApiConfig;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRoutePluginInterface;
use Spryker\Glue\Kernel\AbstractPlugin;

class OutboundRequestsResourceRoutePlugin extends AbstractPlugin implements ResourceRoutePluginInterface
{
    /** @param \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface $resourceRouteCollection
     *
     * @return \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface
     */
    public function configure(ResourceRouteCollectionInterface $resourceRouteCollection
    ): ResourceRouteCollectionInterface {
        $resourceRouteCollection
            ->addGet(OutboundRequestsRestApiConfig::ACTION_OUTBOUND_REQUESTS_GET, false);
        return $resourceRouteCollection;
    }

    /**
     * {@inheritDoc}
     *
     * @return string
     * @api
     *
     */
    public function getResourceType(): string
    {
        return OutboundRequestsRestApiConfig::RESOURCE_OUTBOUND_REQUESTS;
    }

    /**
     * {@inheritDoc}
     *
     * @return string
     * @api
     *
     */
    public function getController(): string
    {
        return OutboundRequestsRestApiConfig::CONTROLLER_OUTBOUND_REQUESTS;
    }

    /**
     * {@inheritDoc}
     *
     * @return string
     * @api
     *
     */
    public function getResourceAttributesClassName(): string
    {
        return RestOutboundRequestResponseAttributesTransfer::class;
    }
}
