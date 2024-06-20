<?php

namespace Pyz\Client\OutboundRequest\Zed;

use Generated\Shared\Transfer\OutboundRequestTransfer;
use Generated\Shared\Transfer\OutboundResponseCollectionTransfer;

interface OutboundRequestZedStubInterface
{
    /**
     * @param \Generated\Shared\Transfer\OutboundRequestTransfer $outboundRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OutboundResponseCollectionTransfer
     */
    public function callOutboundRequest(OutboundRequestTransfer $outboundRequestTransfer
    ): OutboundResponseCollectionTransfer;
}
