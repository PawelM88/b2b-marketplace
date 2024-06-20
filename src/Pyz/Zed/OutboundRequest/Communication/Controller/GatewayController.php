<?php

namespace Pyz\Zed\OutboundRequest\Communication\Controller;

use Generated\Shared\Transfer\OutboundResponseCollectionTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;
use Generated\Shared\Transfer\OutboundRequestTransfer;

/**
 * @method \Pyz\Zed\OutboundRequest\Business\OutboundRequestFacadeInterface getFacade()
 */
class GatewayController extends AbstractGatewayController
{
    /**
     * @param \Generated\Shared\Transfer\OutboundRequestTransfer $outboundRequestTransfer
     *
     * @return \Generated\Shared\Transfer\OutboundResponseCollectionTransfer
     */
    public function callOutboundRequestAction(OutboundRequestTransfer $outboundRequestTransfer
    ): OutboundResponseCollectionTransfer {
        return $this->getFacade()->callOutboundRequest($outboundRequestTransfer);
    }
}
