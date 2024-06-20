<?php

namespace Pyz\Zed\OutboundRequest\Business;

use Generated\Shared\Transfer\OutboundRequestTransfer;
use Generated\Shared\Transfer\OutboundResponseCollectionTransfer;

interface OutboundRequestFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\OutboundRequestTransfer $outboundRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OutboundResponseCollectionTransfer
     */
    public function callOutboundRequest(OutboundRequestTransfer $outboundRequestTransfer
    ): OutboundResponseCollectionTransfer;
}
