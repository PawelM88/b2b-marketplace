<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Company;

use Spryker\Zed\Company\CompanyDependencyProvider as SprykerCompanyDependencyProvider;
use Spryker\Zed\CompanyBusinessUnit\Communication\Plugin\Company\CompanyBusinessUnitCreatePlugin;
use Spryker\Zed\CompanyMailConnector\Communication\Plugin\Company\SendCompanyStatusChangePlugin;
use Spryker\Zed\CompanyRole\Communication\Plugin\CompanyRoleCreatePlugin;
use Spryker\Zed\CompanyUser\Communication\Plugin\Company\CompanyUserCreatePlugin;
use Spryker\Zed\Kernel\Container;

class CompanyDependencyProvider extends SprykerCompanyDependencyProvider
{
    /**
     * @var string
     */
    public const FACADE_COMPANY_ROLE = 'FACADE_COMPANY_ROLE';

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
        $container = $this->addCompanyRoleFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @throws \Spryker\Service\Container\Exception\FrozenServiceException !
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyRoleFacade(Container $container): Container
    {
        $container->set(static::FACADE_COMPANY_ROLE, function (Container $container) {
            return $container->getLocator()->companyRole()->facade();
        });

        return $container;
    }

    /**
     * @return array<\Spryker\Zed\CompanyExtension\Dependency\Plugin\CompanyPostCreatePluginInterface>
     */
    protected function getCompanyPostCreatePlugins(): array
    {
        return [
            new CompanyBusinessUnitCreatePlugin(),
            new CompanyRoleCreatePlugin(),
            new CompanyUserCreatePlugin(),
        ];
    }

    /**
     * @return array<\Spryker\Zed\CompanyExtension\Dependency\Plugin\CompanyPostSavePluginInterface>
     */
    protected function getCompanyPostSavePlugins(): array
    {
        return [
            new SendCompanyStatusChangePlugin(),
        ];
    }
}
