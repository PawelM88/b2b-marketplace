<?php

namespace Pyz\Glue\OutboundRequestsRestApi\Processor\Mapper;

use Generated\Shared\Transfer\RestOutboundRequestResponseAttributesTransfer;

class OutboundRequestsResourceMapper implements OutboundRequestsResourceMapperInterface
{
    /**
     * @param $outboundRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestOutboundRequestResponseAttributesTransfer
     */
    public function mapOutboundRequestDataToOutboundRequestRestAttributes( $outboundRequestTransfer
    ): RestOutboundRequestResponseAttributesTransfer {
        return (new RestOutboundRequestResponseAttributesTransfer())->fromArray(
            $outboundRequestTransfer,
            true
        );
    }
}
