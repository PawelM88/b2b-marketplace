<?php

declare(strict_types=1);

namespace Pyz\Glue\ContentItemsRestApi;

use Spryker\Glue\Kernel\Backend\AbstractBundleDependencyProvider;
use Spryker\Glue\Kernel\Container;

class ContentItemsRestApiDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const CLIENT_CONTENT_ITEM_STORAGE = 'CLIENT_CONTENT_ITEM_STORAGE';

    /**
     * @param \Spryker\Glue\Kernel\Backend\Container $container
     *
     * @throws \Spryker\Service\Container\Exception\FrozenServiceException !
     * @return \Spryker\Glue\Kernel\Backend\Container
     */
    public function provideDependencies(Container $container): Container
    {
        $container = parent::provideDependencies($container);
        $container = $this->addContentItemStorageClient($container);

        return $container;
    }

    /**
     * @param \Spryker\Glue\Kernel\Backend\Container $container
     *
     * @throws \Spryker\Service\Container\Exception\FrozenServiceException !
     *
     * @return \Spryker\Glue\Kernel\Backend\Container
     */
    protected function addContentItemStorageClient(Container $container): Container
    {
        $container->set(
            self::CLIENT_CONTENT_ITEM_STORAGE,
            static fn(Container $container) => $container->getLocator()->contentItemStorage()->client()
        );

        return $container;
    }
}
