<?php

namespace Pyz\Glue\OutboundRequestsRestApi;

use Spryker\Glue\Kernel\AbstractBundleDependencyProvider;
use Spryker\Glue\Kernel\Container;

class OutboundRequestsRestApiDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @string
     */
    public const CLIENT_OUTBOUND_REQUEST = 'CLIENT_OUTBOUND_REQUEST';

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @throws \Spryker\Service\Container\Exception\FrozenServiceException !
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    public function provideDependencies(Container $container): Container
    {
        return $this->addOutboundRequestClient($container);
    }

    /**
     * @param \Spryker\Glue\Kernel\Container $container
     *
     * @throws \Spryker\Service\Container\Exception\FrozenServiceException !
     *
     * @return \Spryker\Glue\Kernel\Container
     */
    protected function addOutboundRequestClient(Container $container): Container
    {
        $container->set(
            self::CLIENT_OUTBOUND_REQUEST,
            static fn(Container $container) => $container->getLocator()->outboundRequest()->client()
        );

        return $container;
    }
}
