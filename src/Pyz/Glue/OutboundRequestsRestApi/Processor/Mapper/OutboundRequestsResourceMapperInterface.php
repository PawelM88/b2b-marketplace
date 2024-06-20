<?php

namespace Pyz\Glue\OutboundRequestsRestApi\Processor\Mapper;

use Generated\Shared\Transfer\RestOutboundRequestResponseAttributesTransfer;

interface OutboundRequestsResourceMapperInterface
{
    /**
     * @param $outboundRequestTransfer
     *
     * @return \Generated\Shared\Transfer\RestOutboundRequestResponseAttributesTransfer
     */
    public function mapOutboundRequestDataToOutboundRequestRestAttributes( $outboundRequestTransfer
    ): RestOutboundRequestResponseAttributesTransfer;
}
