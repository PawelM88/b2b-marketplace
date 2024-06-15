<?php

namespace Pyz\Glue\ContentItemsRestApi\Processor\RestResponseBuilder;

use Generated\Shared\Transfer\ContentItemsStorageTransfer;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;

interface ContentItemsRestResponseBuilderInterface
{
    /**
     * @param \Generated\Shared\Transfer\ContentItemsStorageTransfer $contentItemStorageTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createContentItemRestResponse(ContentItemsStorageTransfer $contentItemStorageTransfer): RestResponseInterface;

    /**
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createContentItemNotFoundErrorRestResponse(): RestResponseInterface;

    /**
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createContentItemKeyIsMissingErrorRestResponse(): RestResponseInterface;
}
