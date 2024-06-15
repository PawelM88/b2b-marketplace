<?php

declare(strict_types=1);

namespace Pyz\Client\ContentItemStorage;

use Pyz\Client\ContentItemStorage\ContentItemStorage\ContentItemStorageReader;
use Pyz\Client\ContentItemStorage\ContentItemStorage\ContentItemStorageReaderInterface;
use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Service\Synchronization\SynchronizationServiceInterface;

class ContentItemStorageFactory extends AbstractFactory
{
    /**
     * @throws \Spryker\Client\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Client\ContentItemStorage\ContentItemStorage\ContentItemStorageReaderInterface
     */
    public function createContentItemStorageReader(): ContentItemStorageReaderInterface
    {
        return new ContentItemStorageReader(
            $this->getSynchronizationService(),
            $this->getStorageClient(),
        );
    }

    /**
     * @throws \Spryker\Client\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Spryker\Service\Synchronization\SynchronizationServiceInterface
     */
    public function getSynchronizationService(): SynchronizationServiceInterface
    {
        return $this->getProvidedDependency(ContentItemStorageDependencyProvider::SERVICE_SYNCHRONIZATION);
    }

    /**
     * @throws \Spryker\Client\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Spryker\Client\Storage\StorageClientInterface
     */
    public function getStorageClient(): StorageClientInterface
    {
        return $this->getProvidedDependency(ContentItemStorageDependencyProvider::CLIENT_STORAGE);
    }
}
