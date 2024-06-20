<?php

namespace Pyz\Zed\OutboundRequest;

use GuzzleHttp\Client;
use Spryker\Service\Container\Exception\FrozenServiceException;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

class OutboundRequestDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @return string
     */
    public const GUZZLE_HTTP_CLIENT = 'GUZZLE_HTTP_CLIENT';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @throws \Spryker\Service\Container\Exception\FrozenServiceException !
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        return $this->addGuzzleHttpClient($container);
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @throws \Spryker\Service\Container\Exception\FrozenServiceException !
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    private function addGuzzleHttpClient(Container $container): Container
    {
        $container->set(self::GUZZLE_HTTP_CLIENT, fn() => new Client());

        return $container;
    }
}
