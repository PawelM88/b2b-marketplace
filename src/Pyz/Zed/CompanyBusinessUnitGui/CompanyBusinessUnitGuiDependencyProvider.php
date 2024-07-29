<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\CompanyBusinessUnitGui;

use Spryker\Zed\CompanyBusinessUnitGui\CompanyBusinessUnitGuiDependencyProvider as SprykerCompanyBusinessUnitGuiDependencyProvider;
use Spryker\Zed\CompanyUnitAddressGui\Communication\Plugin\CompanyBusinessUnitGui\CompanyBusinessUnitAddressFieldPlugin;
use Spryker\Zed\Kernel\Container;

class CompanyBusinessUnitGuiDependencyProvider extends SprykerCompanyBusinessUnitGuiDependencyProvider
{
    /**
     * @var string
     */
    public const COMPANY_BUSINESS_UNIT_CSV_IMPORTER_FACADE = 'COMPANY_BUSINESS_UNIT_CSV_IMPORTER_FACADE';

    /**
     * @var string
     */
    public const TRANSLATOR_FACADE = 'TRANSLATOR_FACADE';

    /**
     * @var string
     */
    public const COMPANY_UNIT_ADDRESS_FACADE = 'COMPANY_UNIT_ADDRESS_FACADE';

    /**
     * @var string
     */
    public const PYZ_COMPANY_FACADE = 'PYZ_COMPANY_FACADE';

    /**
     * @var string
     */
    public const PYZ_COMPANY_BUSINESS_UNIT_FACADE = 'PYZ_COMPANY_BUSINESS_UNIT_FACADE';

    /**
     * @var string
     */
    public const CUSTOMER_FACADE = 'CUSTOMER_FACADE';

    /**
     * @var string
     */
    public const COMPANY_USER_FACADE = 'COMPANY_USER_FACADE';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @throws \Spryker\Service\Container\Exception\FrozenServiceException !
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);

        $container = $this->addCompanyBusinessUnitCsvImporterFacade($container);
        $container = $this->addTranslatorFacade($container);
        $container = $this->addCompanyUnitAddressFacade($container);
        $container = $this->addPyzCompanyFacade($container);
        $container = $this->addPyzCompanyBusinessUnitFacade($container);
        $container = $this->addCustomerFacade($container);
        $container = $this->addCompanyUserFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @throws \Spryker\Service\Container\Exception\FrozenServiceException !
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function addCompanyBusinessUnitCsvImporterFacade(Container $container): Container
    {
        $container->set(static::COMPANY_BUSINESS_UNIT_CSV_IMPORTER_FACADE, function (Container $container) {
            return $container->getLocator()->companyBusinessUnitCsvImport()->facade();
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
    protected function addTranslatorFacade(Container $container): Container
    {
        $container->set(static::TRANSLATOR_FACADE, function (Container $container) {
            return $container->getLocator()->translator()->facade();
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
    protected function addCompanyUnitAddressFacade(Container $container): Container
    {
        $container->set(static::COMPANY_UNIT_ADDRESS_FACADE, function (Container $container) {
            return $container->getLocator()->companyUnitAddress()->facade();
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
    protected function addPyzCompanyFacade(Container $container): Container
    {
        $container->set(static::PYZ_COMPANY_FACADE, function (Container $container) {
            return $container->getLocator()->company()->facade();
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
    protected function addPyzCompanyBusinessUnitFacade(Container $container): Container
    {
        $container->set(static::PYZ_COMPANY_BUSINESS_UNIT_FACADE, function (Container $container) {
            return $container->getLocator()->companyBusinessUnit()->facade();
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
    protected function addCustomerFacade(Container $container): Container
    {
        $container->set(static::CUSTOMER_FACADE, function (Container $container) {
            return $container->getLocator()->customer()->facade();
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
    protected function addCompanyUserFacade(Container $container): Container
    {
        $container->set(static::COMPANY_USER_FACADE, function (Container $container) {
            return $container->getLocator()->companyUser()->facade();
        });

        return $container;
    }

    /**
     * @return array<\Spryker\Zed\CompanyBusinessUnitGuiExtension\Communication\Plugin\CompanyBusinessUnitFormExpanderPluginInterface>
     */
    protected function getCompanyBusinessUnitEditFormExpanderPlugins(): array
    {
        return [
            new CompanyBusinessUnitAddressFieldPlugin(),
        ];
    }
}
