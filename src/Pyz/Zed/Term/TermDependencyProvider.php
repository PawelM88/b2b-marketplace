<?php

declare(strict_types=1);

namespace Pyz\Zed\Term;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class TermDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const CMS_STORAGE_FACADE = 'CMS_STORAGE_FACADE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @throws \Spryker\Service\Container\Exception\FrozenServiceException !
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = $this->addCmsPageStorageFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @throws \Spryker\Service\Container\Exception\FrozenServiceException !
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCmsPageStorageFacade(Container $container): Container
    {
        $container->set(static::CMS_STORAGE_FACADE, function (Container $container) {
            return $container->getLocator()->cmsStorage()->facade();
        });

        return $container;
    }
}
