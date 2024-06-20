<?php

namespace Pyz\Zed\OutboundRequest\Business\Mapper;

use Generated\Shared\Transfer\OutboundResponseCollectionTransfer;
use Generated\Shared\Transfer\OutboundHttpResponseTransfer;

interface OutboundRequestMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\OutboundHttpResponseTransfer $outboundHttpResponse
     *
     * @return \Generated\Shared\Transfer\OutboundResponseCollectionTransfer
     */
    public function mapOutboundHttpResponseToOutboundResponseTransfer(
        OutboundHttpResponseTransfer $outboundHttpResponse
    ): OutboundResponseCollectionTransfer;
}
