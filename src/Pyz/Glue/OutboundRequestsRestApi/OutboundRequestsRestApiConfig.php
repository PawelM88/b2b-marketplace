<?php

namespace Pyz\Glue\OutboundRequestsRestApi;

use Spryker\Glue\Kernel\AbstractBundleConfig;

class OutboundRequestsRestApiConfig extends AbstractBundleConfig
{
    /**
     * @string
     */
    public const ACTION_OUTBOUND_REQUESTS_GET = 'get';

    /**
     * @string
     */
    public const RESOURCE_OUTBOUND_REQUESTS = 'outbound-request';

    /**
     * @string
     */
    public const CONTROLLER_OUTBOUND_REQUESTS = 'outbound-requests-resource';
}
