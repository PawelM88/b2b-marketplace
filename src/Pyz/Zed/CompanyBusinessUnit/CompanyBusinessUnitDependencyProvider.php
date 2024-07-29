<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CompanyBusinessUnit;

use Spryker\Zed\CompanyBusinessUnit\CompanyBusinessUnitDependencyProvider as SprykerCompanyBusinessUnitDependencyProvider;
use Spryker\Zed\CompanyUnitAddress\Communication\Plugin\CompanyBusinessUnit\CompanyBusinessUnitAddressesCompanyBusinessUnitExpanderPlugin;
use Spryker\Zed\CompanyUnitAddress\Communication\Plugin\CompanyBusinessUnitAddressSaverPlugin;
use Spryker\Zed\Kernel\Container;
use Spryker\Zed\MerchantRelationRequest\Communication\Plugin\CompanyBusinessUnit\MerchantRelationRequestCompanyBusinessUnitPreDeletePlugin;
use Spryker\Zed\ShoppingList\Communication\Plugin\CompanyBusinessUnit\CompanyBusinessUnitPreDeletePlugin;

class CompanyBusinessUnitDependencyProvider extends SprykerCompanyBusinessUnitDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_COMPANY_BUSINESS_UNIT = 'FACADE_COMPANY_BUSINESS_UNIT';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @throws \Spryker\Service\Container\Exception\FrozenServiceException !
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        parent::provideBusinessLayerDependencies($container);
        $container = $this->addCompanyBusinessUnitFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @throws \Spryker\Service\Container\Exception\FrozenServiceException !
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyBusinessUnitFacade(Container $container): Container
    {
        $container->set(static::FACADE_COMPANY_BUSINESS_UNIT, function (Container $container) {
            return $container->getLocator()->companyBusinessUnit()->facade();
        });

        return $container;
    }

    /**
     * @return array<\Spryker\Zed\CompanyBusinessUnitExtension\Dependency\Plugin\CompanyBusinessUnitPostSavePluginInterface>
     */
    protected function getCompanyBusinessUnitPostSavePlugins(): array
    {
        return [
            new CompanyBusinessUnitAddressSaverPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\CompanyBusinessUnitExtension\Dependency\Plugin\CompanyBusinessUnitExpanderPluginInterface>
     */
    protected function getCompanyBusinessUnitExpanderPlugins(): array
    {
        return [
            new CompanyBusinessUnitAddressesCompanyBusinessUnitExpanderPlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\CompanyBusinessUnitExtension\Dependency\Plugin\CompanyBusinessUnitPreDeletePluginInterface>
     */
    protected function getCompanyBusinessUnitPreDeletePlugins(): array
    {
        return [
            new CompanyBusinessUnitPreDeletePlugin(),
            new MerchantRelationRequestCompanyBusinessUnitPreDeletePlugin(),
        ];
    }
}
