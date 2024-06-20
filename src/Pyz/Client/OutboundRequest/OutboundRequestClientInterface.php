<?php

namespace Pyz\Client\OutboundRequest;

use Generated\Shared\Transfer\OutboundRequestTransfer;
use Generated\Shared\Transfer\OutboundResponseCollectionTransfer;

interface OutboundRequestClientInterface
{
    /**
     * Specification:
     * - Does Zed call.
     * - Calls outbound request.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OutboundRequestTransfer $outboundRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OutboundResponseCollectionTransfer
     */
    public function callOutboundRequest(OutboundRequestTransfer $outboundRequestTransfer
    ): OutboundResponseCollectionTransfer;
}
