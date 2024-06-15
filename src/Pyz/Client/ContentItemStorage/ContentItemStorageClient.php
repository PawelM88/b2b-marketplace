<?php

declare(strict_types=1);

namespace Pyz\Client\ContentItemStorage;

use Generated\Shared\Transfer\ContentItemsStorageTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \Pyz\Client\ContentItemStorage\ContentItemStorageFactory getFactory()
 */
class ContentItemStorageClient extends AbstractClient implements ContentItemStorageClientInterface
{
 /**
  * @param string $contentItemKey
  * @param string $localeName
  *
  * @throws \Spryker\Client\Kernel\Exception\Container\ContainerKeyNotFoundException !
  *
  * @return \Generated\Shared\Transfer\ContentItemsStorageTransfer|null
  */
    public function getContentItemByKey(string $contentItemKey, string $localeName): ?ContentItemsStorageTransfer
    {
        return $this->getFactory()
            ->createContentItemStorageReader()
            ->getContentItemByKey($contentItemKey, $localeName);
    }
}
