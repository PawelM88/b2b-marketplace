<?php

namespace Pyz\Zed\OutboundRequest;

use Pyz\Shared\OutboundRequest\OutboundRequestConstants;
use Spryker\Zed\Kernel\AbstractBundleConfig;

class OutboundRequestConfig extends AbstractBundleConfig
{
    /**
     * @return string
     */
    public function getOutboundRequestDataUrl(): string
    {
        return $this->get(OutboundRequestConstants::OUTBOUND_REQUEST_GET_DATA_URL, '');
    }

    /**
     * @return string
     */
    public function getOutboundRequestDefaultMethod(): string
    {
        return $this->get(OutboundRequestConstants::OUTBOUND_REQUEST_DEFAULT_METHOD, '');
    }

    /**
     * @return array
     */
    public function getOutboundRequestConnectTimeout(): array
    {
        return $this->get(OutboundRequestConstants::OUTBOUND_REQUEST_CONNECT_TIMEOUT, '');
    }
}
