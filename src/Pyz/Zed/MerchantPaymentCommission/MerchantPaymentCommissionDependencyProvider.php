<?php

declare(strict_types=1);

namespace Pyz\Zed\MerchantPaymentCommission;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\Store\Business\StoreFacade as SprykerStoreFacade;

class MerchantPaymentCommissionDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_STORE = 'FACADE_STORE';

    /**
     * @param $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies($container): Container
    {
        $container = $this->addStoreFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @throws \Spryker\Service\Container\Exception\FrozenServiceException !
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addStoreFacade(Container $container): Container
    {
        $container->set(static::FACADE_STORE, function (Container $container) {
            return new SprykerStoreFacade();
        });

        return $container;
    }
}
