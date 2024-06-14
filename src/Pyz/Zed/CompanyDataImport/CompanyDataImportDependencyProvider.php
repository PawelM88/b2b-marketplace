<?php

declare(strict_types=1);

namespace Pyz\Zed\CompanyDataImport;

use Spryker\Zed\DataImport\DataImportDependencyProvider;
use Spryker\Zed\Kernel\Container;

class CompanyDataImportDependencyProvider extends DataImportDependencyProvider
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
        $container = parent::provideBusinessLayerDependencies($container);

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
}
