<?php

declare(strict_types=1);

namespace Pyz\Zed\MerchantPage;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class MerchantPageDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const SPRYKER_FACADE_MAIL = 'SPRYKER_FACADE_MAIL';

    /**
     * @var string
     */
    public const SPRYKER_FACADE_MERCHANT_PROFILE = 'SPRYKER_FACADE_MERCHANT_PROFILE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @throws \Spryker\Service\Container\Exception\FrozenServiceException !
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);
        $container = $this->addSprykerMailFacade($container);
        $container = $this->addSprykerMerchantProfileFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @throws \Spryker\Service\Container\Exception\FrozenServiceException !
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addSprykerMailFacade(Container $container): Container
    {
        $container->set(static::SPRYKER_FACADE_MAIL, function (Container $container) {
            return $container->getLocator()->mail()->facade();
        });

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @throws \Spryker\Service\Container\Exception\FrozenServiceException !
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addSprykerMerchantProfileFacade(Container $container): Container
    {
        $container->set(static::SPRYKER_FACADE_MERCHANT_PROFILE, function (Container $container) {
            return $container->getLocator()->merchantProfile()->facade();
        });

        return $container;
    }
}
