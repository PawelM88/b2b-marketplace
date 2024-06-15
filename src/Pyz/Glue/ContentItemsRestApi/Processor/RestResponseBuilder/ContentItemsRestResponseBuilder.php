<?php

declare(strict_types=1);

namespace Pyz\Glue\ContentItemsRestApi\Processor\RestResponseBuilder;

use Generated\Shared\Transfer\ContentItemsStorageTransfer;
use Generated\Shared\Transfer\RestContentItemsAttributesTransfer;
use Generated\Shared\Transfer\RestErrorMessageTransfer;
use Pyz\Glue\ContentItemsRestApi\ContentItemsRestApiConfig;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface;
use Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface;
use Symfony\Component\HttpFoundation\Response;

class ContentItemsRestResponseBuilder implements ContentItemsRestResponseBuilderInterface
{
    /**
     * @param \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceBuilderInterface $restResourceBuilder
     */
    public function __construct(
        protected RestResourceBuilderInterface $restResourceBuilder,
    ) {
    }

    /**
     * @param \Generated\Shared\Transfer\ContentItemsStorageTransfer $contentItemStorageTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createContentItemRestResponse(ContentItemsStorageTransfer $contentItemStorageTransfer
    ): RestResponseInterface {
        $restContentItemsAttributesTransfer = new RestContentItemsAttributesTransfer();
        $restContentItemsAttributesTransfer->fromArray($contentItemStorageTransfer->toArray(), true);

        $contentItemRestResource = $this->createContentItemRestResource(
            $restContentItemsAttributesTransfer
        );

        return $this->restResourceBuilder->createRestResponse()->addResource($contentItemRestResource);
    }

    /**
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createContentItemNotFoundErrorRestResponse(): RestResponseInterface
    {
        return $this->restResourceBuilder->createRestResponse()->addError(
            (new RestErrorMessageTransfer())
                ->setCode(ContentItemsRestApiConfig::RESPONSE_CODE_CONTENT_ITEM_NOT_FOUND)
                ->setStatus(Response::HTTP_NOT_FOUND)
                ->setDetail(ContentItemsRestApiConfig::RESPONSE_DETAIL_CONTENT_ITEM_NOT_FOUND)
        );
    }

    /**
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResponseInterface
     */
    public function createContentItemKeyIsMissingErrorRestResponse(): RestResponseInterface
    {
        return $this->restResourceBuilder->createRestResponse()->addError(
            (new RestErrorMessageTransfer())
                ->setCode(ContentItemsRestApiConfig::RESPONSE_CODE_CONTENT_ITEM_KEY_IS_MISSING)
                ->setStatus(Response::HTTP_BAD_REQUEST)
                ->setDetail(ContentItemsRestApiConfig::RESPONSE_DETAIL_CONTENT_ITEM_KEY_IS_MISSING)
        );
    }

    /**
     * @param \Generated\Shared\Transfer\RestContentItemsAttributesTransfer $restContentItemsAttributesTransfer
     *
     * @return \Spryker\Glue\GlueApplication\Rest\JsonApi\RestResourceInterface
     */
    protected function createContentItemRestResource(
        RestContentItemsAttributesTransfer $restContentItemsAttributesTransfer
    ): RestResourceInterface {
        return $this->restResourceBuilder->createRestResource(
            ContentItemsRestApiConfig::RESOURCE_CONTENT_ITEMS,
            null,
            $restContentItemsAttributesTransfer
        );
    }
}
