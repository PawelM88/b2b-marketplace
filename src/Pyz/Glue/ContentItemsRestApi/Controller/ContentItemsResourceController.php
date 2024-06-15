<?php

declare(strict_types=1);

namespace Pyz\Glue\ContentItemsRestApi\Controller;

use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;
use Spryker\Glue\Kernel\Backend\Controller\AbstractController;

/**
 * @method \Pyz\Glue\ContentItemsRestApi\ContentItemsRestApiFactory getFactory()
 */
class ContentItemsResourceController extends AbstractController
{
    /**
     * @Glue({
     *     "getResourceByKey": {
     *          "summary": [
     *              "Retrieves a content item by key."
     *          ],
     *          "responses": {
     *              "400": "Content item key is missing.",
     *              "404": "Content item not found."
     *          }
     *     }
     * })
     *
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @throws \Spryker\Glue\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function getAction(RestRequestInterface $restRequest): RestResponseInterface
    {
        return $this->getFactory()->createContentItemReader()->getContentItemByKey($restRequest);
    }
}
