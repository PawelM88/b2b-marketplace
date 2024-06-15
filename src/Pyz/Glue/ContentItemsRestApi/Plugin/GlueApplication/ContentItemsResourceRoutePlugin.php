<?php

declare(strict_types=1);

namespace Pyz\Glue\ContentItemsRestApi\Plugin\GlueApplication;

use Generated\Shared\Transfer\RestContentItemsAttributesTransfer;
use Pyz\Glue\ContentItemsRestApi\ContentItemsRestApiConfig;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface;
use Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRoutePluginInterface;
use Spryker\Glue\Kernel\Backend\AbstractPlugin;

class ContentItemsResourceRoutePlugin extends AbstractPlugin implements ResourceRoutePluginInterface
{
    /**
     * {@inheritDoc}
     * - Configures available actions for content-items resource.
     *
     * @api
     *
     * @param \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface $resourceRouteCollection
     *
     * @return \Spryker\Glue\GlueApplicationExtension\Dependency\Plugin\ResourceRouteCollectionInterface
     */
    public function configure(ResourceRouteCollectionInterface $resourceRouteCollection
    ): ResourceRouteCollectionInterface {
        $resourceRouteCollection
            ->addGet(ContentItemsRestApiConfig::ACTION_CONTENT_ITEMS_GET, false);

        return $resourceRouteCollection;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    public function getResourceType(): string
    {
        return ContentItemsRestApiConfig::RESOURCE_CONTENT_ITEMS;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    public function getController(): string
    {
        return ContentItemsRestApiConfig::CONTROLLER_CONTENT_ITEMS;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    public function getResourceAttributesClassName(): string
    {
        return RestContentItemsAttributesTransfer::class;
    }
}
