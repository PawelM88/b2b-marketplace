<?php

declare(strict_types=1);

namespace Pyz\Client\ContentItemStorage\ContentItemStorage;

use Generated\Shared\Transfer\ContentItemsStorageTransfer;
use Generated\Shared\Transfer\SynchronizationDataTransfer;
use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Service\Synchronization\SynchronizationServiceInterface;

class ContentItemStorageReader implements ContentItemStorageReaderInterface
{
    /**
     * @var string
     */
    protected const CONTENT_RESOURCE_NAME = 'content';

    /**
     * @param \Spryker\Service\Synchronization\SynchronizationServiceInterface $synchronizationService
     * @param \Spryker\Client\Storage\StorageClientInterface $storageClient
     */
    public function __construct(
        protected SynchronizationServiceInterface $synchronizationService,
        protected StorageClientInterface $storageClient,
    ) {
    }

    /**
     * @param string $contentItemKey
     * @param string $localeName
     *
     * @return \Generated\Shared\Transfer\ContentItemsStorageTransfer|null
     */
    public function getContentItemByKey(string $contentItemKey, string $localeName): ?ContentItemsStorageTransfer
    {
        $syncDataTransfer = new SynchronizationDataTransfer();
        $syncDataTransfer->setReference($contentItemKey)->setLocale($localeName);

        $key = $this->synchronizationService
            ->getStorageKeyBuilder(self::CONTENT_RESOURCE_NAME)
            ->generateKey($syncDataTransfer);

        $data = $this->storageClient->get($key);

        if (!$data) {
            return null;
        }

        $contentItemsStorageTransfer = new ContentItemsStorageTransfer();
        $contentItemsStorageTransfer->fromArray($data, true);

        return $contentItemsStorageTransfer;
    }
}
