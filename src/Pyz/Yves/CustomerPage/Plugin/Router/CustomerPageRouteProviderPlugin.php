<?php

declare(strict_types=1);

namespace Pyz\Yves\CustomerPage\Plugin\Router;

use Spryker\Yves\Router\Route\RouteCollection;
use SprykerShop\Yves\CustomerPage\Plugin\Router\CustomerPageRouteProviderPlugin as SprykerCustomerPageRouteProviderPlugin;

class CustomerPageRouteProviderPlugin extends SprykerCustomerPageRouteProviderPlugin
{
    /**
     * @var string
     */
    public const ROUTE_NAME_LOGIN = 'login';

    /**
     * @var string
     */
    public const ROUTE_NAME_LOGOUT = 'logout';

    /**
     * @var string
     */
    public const ROUTE_NAME_TERM_CONSENT = 'term-consent';

    /**
     * @var string
     */
    public const ROUTE_NAME_CUSTOMER_OVERVIEW = 'customer/overview';

    /**
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    public function addRoutes(RouteCollection $routeCollection): RouteCollection
    {
        $routeCollection = parent::addRoutes($routeCollection);

        $routeCollection = $this->addTermConsentRoute($routeCollection);

        return $routeCollection;
    }

    /**
     * @param \Spryker\Yves\Router\Route\RouteCollection $routeCollection
     *
     * @return \Spryker\Yves\Router\Route\RouteCollection
     */
    protected function addTermConsentRoute(RouteCollection $routeCollection): RouteCollection
    {
        $route = $this->buildRoute('/term-consent', 'CustomerPage', 'TermConsent', 'acceptTermsAction');
        $routeCollection->add(static::ROUTE_NAME_TERM_CONSENT, $route);

        return $routeCollection;
    }
}
