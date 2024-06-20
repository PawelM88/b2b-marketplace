<?php

namespace Pyz\Zed\OutboundRequest\Business;

use Generated\Shared\Transfer\OutboundRequestTransfer;
use Generated\Shared\Transfer\OutboundResponseCollectionTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pyz\Zed\OutboundRequest\Business\OutboundRequestBusinessFactory getFactory()
 */
class OutboundRequestFacade extends AbstractFacade implements OutboundRequestFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\OutboundRequestTransfer $outboundRequestTransfer
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Generated\Shared\Transfer\OutboundResponseCollectionTransfer
     */
    public function callOutboundRequest(OutboundRequestTransfer $outboundRequestTransfer
    ): OutboundResponseCollectionTransfer {
        return $this->getFactory()
            ->createOutboundRequestReader()
            ->doOutboundRequest($outboundRequestTransfer);
    }
}
