<?php

declare(strict_types=1);

namespace Pyz\Glue\ContentItemsRestApi;

class ContentItemsRestApiConfig
{
    /**
     * @var string
     */
    public const ACTION_CONTENT_ITEMS_GET = 'get';

    /**
     * @var string
     */
    public const RESOURCE_CONTENT_ITEMS = 'content-items';

    /**
     * @var string
     */
    public const CONTROLLER_CONTENT_ITEMS = 'content-items-resource';

    /**
     * @var string
     */
    public const RESPONSE_CODE_CONTENT_ITEM_NOT_FOUND = '2201';

    /**
     * @var string
     */
    public const RESPONSE_DETAIL_CONTENT_ITEM_NOT_FOUND = 'Content item not found';

    /**
     * @var string
     */
    public const RESPONSE_CODE_CONTENT_ITEM_KEY_IS_MISSING = '2202';

    /**
     * @var string
     */
    public const RESPONSE_DETAIL_CONTENT_ITEM_KEY_IS_MISSING = 'Content item key is missing.';
}
