<?php

declare(strict_types=1);

namespace Pyz\Zed\CmsStorage\Business;

use Pyz\Zed\CmsStorage\Business\CmsStorage\CmsStorageReader;
use Pyz\Zed\CmsStorage\Business\CmsStorage\CmsStorageReaderInterface;
use Pyz\Zed\CmsStorage\CmsStorageDependencyProvider;
use Spryker\Client\Locale\LocaleClientInterface;
use Spryker\Client\Store\StoreClientInterface;
use Spryker\Zed\CmsStorage\Business\CmsStorageBusinessFactory as SprykerCmsStorageBusinessFactory;

/**
 * @method \Pyz\Zed\CmsStorage\Persistence\CmsStorageRepositoryInterface getRepository()
 * @method \Pyz\Zed\CmsStorage\CmsStorageConfig getConfig()
 */
class CmsStorageBusinessFactory extends SprykerCmsStorageBusinessFactory
{
    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Zed\CmsStorage\Business\CmsStorage\CmsStorageReaderInterface
     */
    public function createCmsPageStorageReader(): CmsStorageReaderInterface
    {
        return new CmsStorageReader(
            $this->getRepository(),
            $this->getStoreClient(),
            $this->getLocaleClient(),
        );
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Spryker\Client\Store\StoreClientInterface
     */
    protected function getStoreClient(): StoreClientInterface
    {
        return $this->getProvidedDependency(CmsStorageDependencyProvider::CLIENT_STORE);
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Spryker\Client\Locale\LocaleClientInterface
     */
    protected function getLocaleClient(): LocaleClientInterface
    {
        return $this->getProvidedDependency(CmsStorageDependencyProvider::CLIENT_LOCALE);
    }
}
