<?php

namespace Pyz\Client\ContentItemStorage\ContentItemStorage;

use Generated\Shared\Transfer\ContentItemsStorageTransfer;

interface ContentItemStorageReaderInterface
{
    /**
     * @param string $contentItemKey
     * @param string $localeName
     *
     * @return \Generated\Shared\Transfer\ContentItemsStorageTransfer|null
     */
    public function getContentItemByKey(string $contentItemKey, string $localeName): ?ContentItemsStorageTransfer;
}
