<?php

namespace Pyz\Client\OutboundRequest;

use Generated\Shared\Transfer\OutboundRequestTransfer;
use Generated\Shared\Transfer\OutboundResponseCollectionTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \Pyz\Client\OutboundRequest\OutboundRequestFactory getFactory()
 */
class OutboundRequestClient extends AbstractClient implements OutboundRequestClientInterface
{
    /**
     * @param \Generated\Shared\Transfer\OutboundRequestTransfer $outboundRequestTransfer
     *
     * @throws \Spryker\Client\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Generated\Shared\Transfer\OutboundResponseCollectionTransfer
     */
    public function callOutboundRequest(OutboundRequestTransfer $outboundRequestTransfer
    ): OutboundResponseCollectionTransfer {
        return $this->getFactory()
            ->createOutboundRequestZedStub()
            ->callOutboundRequest($outboundRequestTransfer);
    }
}
