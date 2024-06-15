<?php

declare(strict_types=1);

namespace Pyz\Glue\ContentItemsRestApi\Processor\Reader;

use Pyz\Client\ContentItemStorage\ContentItemStorageClientInterface;
use Pyz\Glue\ContentItemsRestApi\Processor\RestResponseBuilder\ContentItemsRestResponseBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface;

class ContentItemReader implements ContentItemReaderInterface
{
    /**
     * @param \Pyz\Client\ContentItemStorage\ContentItemStorageClientInterface $contentItemStorageClient
     * @param \Pyz\Glue\ContentItemsRestApi\Processor\RestResponseBuilder\ContentItemsRestResponseBuilderInterface $contentItemsRestResponseBuilder
     */
    public function __construct(
        protected ContentItemStorageClientInterface $contentItemStorageClient,
        protected ContentItemsRestResponseBuilderInterface $contentItemsRestResponseBuilder
    ) {
    }

    /**
     * @param \Spryker\Glue\GlueApplication\Rest\Request\Data\RestRequestInterface $restRequest
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function getContentItemByKey(RestRequestInterface $restRequest): RestResponseInterface
    {
        $contentItemKey = $restRequest->getResource()->getId();
        $localName = $restRequest->getMetadata()->getLocale();

        if (!$contentItemKey)
        {
            return $this->contentItemsRestResponseBuilder->createContentItemKeyIsMissingErrorRestResponse();
        }

        $contentItemStorageTransfer = $this->contentItemStorageClient->getContentItemByKey($contentItemKey, $localName);

        if (!$contentItemStorageTransfer)
        {
            return $this->contentItemsRestResponseBuilder->createContentItemNotFoundErrorRestResponse();
        }

        return $this->contentItemsRestResponseBuilder->createContentItemRestResponse($contentItemStorageTransfer);
    }
}
