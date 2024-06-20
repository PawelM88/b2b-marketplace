<?php

namespace Pyz\Client\OutboundRequest\Zed;

use Generated\Shared\Transfer\OutboundRequestTransfer;
use Generated\Shared\Transfer\OutboundResponseCollectionTransfer;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;

class OutboundRequestZedStub implements OutboundRequestZedStubInterface
{
    /**
     * @var ZedRequestClientInterface
     */
    protected ZedRequestClientInterface $zedRequestClient;

    /**
     * @param \Spryker\Client\ZedRequest\ZedRequestClientInterface $zedRequestClient
     */
    public function __construct(ZedRequestClientInterface $zedRequestClient)
    {
        $this->zedRequestClient = $zedRequestClient;
    }

    /**
     * @param \Generated\Shared\Transfer\OutboundRequestTransfer $outboundRequestTransfer
     *
     * @return \Spryker\Client\ZedRequest\OutboundResponseCollectionTransfer
     */
    public function callOutboundRequest(OutboundRequestTransfer $outboundRequestTransfer
    ): OutboundResponseCollectionTransfer {
        /** @var OutboundResponseCollectionTransfer $outboundResponseCollectionTransfer */

        $outboundResponseCollectionTransfer = $this->zedRequestClient->call(
            '/outbound-request/gateway/call-outbound-request',
            $outboundRequestTransfer
        );

        return $outboundResponseCollectionTransfer;
    }
}
