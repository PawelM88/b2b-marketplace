<?php

namespace Pyz\Zed\OutboundRequest\Business\OutboundRequest;

use Generated\Shared\Transfer\OutboundRequestTransfer;
use Generated\Shared\Transfer\OutboundResponseCollectionTransfer;

interface OutboundRequestReaderInterface
{
    /**
     * @param \Generated\Shared\Transfer\OutboundRequestTransfer $outboundRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OutboundResponseCollectionTransfer
     */
    public function doOutboundRequest(OutboundRequestTransfer $outboundRequestTransfer
    ): OutboundResponseCollectionTransfer;
}
