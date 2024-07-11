<?php

declare(strict_types=1);

namespace Pyz\Zed\TermConsent;

use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class TermConsentDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const TERM_FACADE = 'TERM_FACADE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @throws \Spryker\Service\Container\Exception\FrozenServiceException !
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = $this->addTermFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @throws \Spryker\Service\Container\Exception\FrozenServiceException !
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addTermFacade(Container $container): Container
    {
        $container->set(static::TERM_FACADE, function (Container $container) {
            return $container->getLocator()->term()->facade();
        });

        return $container;
    }
}
