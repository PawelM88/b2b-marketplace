<?php

namespace Pyz\Yves\OutboundRequest\Plugin\Router;

use Spryker\Yves\Router\Plugin\RouteProvider\AbstractRouteProviderPlugin;
use Spryker\Yves\Router\Route\RouteCollection;

class OutboundRequestRouteProviderPlugin extends AbstractRouteProviderPlugin
{
    /**
     * @string
     */
    protected const ROUTE_OUTBOUND_REQUEST_INDEX = 'outbound-request-index';

    /**
     * Specification:
     * - Adds Routes to the RouteCollection.
     *
     * @api
     *
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    public function addRoutes(RouteCollection $routeCollection): RouteCollection
    {
        return $this->addOutboundRequestIndexRoute($routeCollection);
    }

    /**
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addOutboundRequestIndexRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute('/outbound-request', 'OutboundRequest', 'Index', 'indexAction');
        $routeCollection->add(static::ROUTE_OUTBOUND_REQUEST_INDEX, $route);

        return $routeCollection;
    }
}
