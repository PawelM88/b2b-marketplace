<?php

namespace Pyz\Zed\OutboundRequest\Business\Mapper;

use Generated\Shared\Transfer\OutboundResponseCollectionEntityTransfer;
use Generated\Shared\Transfer\OutboundResponseCollectionTransfer;
use Generated\Shared\Transfer\OutboundHttpResponseTransfer;

class OutboundRequestMapper implements OutboundRequestMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\OutboundHttpResponseTransfer $outboundHttpResponse
     *
     * @return \Generated\Shared\Transfer\OutboundResponseCollectionTransfer
     */
    public function mapOutboundHttpResponseToOutboundResponseTransfer(
        OutboundHttpResponseTransfer $outboundHttpResponse
    ): OutboundResponseCollectionTransfer {
        $outboundResponseCollectionEntities = new OutboundResponseCollectionTransfer();

        foreach ($outboundHttpResponse->getJsonObject()->data as $dataEntry) {
            $outboundResponseCollectionEntity = (new OutboundResponseCollectionEntityTransfer())
                ->setId($dataEntry->id)
                ->setVarcharAttribute($dataEntry->varcharAttribute)
                ->setIntAttribute($dataEntry->intAttribute)
                ->setObjectAttribute($dataEntry->objectAttribute)
                ->setArrayAttribute($dataEntry->arrayAttribute);

            $outboundResponseCollectionEntities
                ->addData($outboundResponseCollectionEntity);
        }
        return $outboundResponseCollectionEntities;
    }
}
