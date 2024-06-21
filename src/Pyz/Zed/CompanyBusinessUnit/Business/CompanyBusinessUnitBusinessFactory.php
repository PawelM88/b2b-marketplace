<?php

declare(strict_types=1);

namespace Pyz\Zed\CompanyBusinessUnit\Business;

use Pyz\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitCreator\CompanyBusinessUnitCreator;
use Pyz\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitCreator\CompanyBusinessUnitCreatorInterface;
use Pyz\Zed\CompanyBusinessUnit\CompanyBusinessUnitDependencyProvider;
use Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitBusinessFactory as SprykerCompanyBusinessUnitBusinessFactory;

/**
 * @method \Pyz\Zed\CompanyBusinessUnit\Persistence\CompanyBusinessUnitRepositoryInterface getRepository()
 * @method \Pyz\Zed\CompanyBusinessUnit\Persistence\CompanyBusinessUnitEntityManagerInterface getEntityManager()
 * @method \Spryker\Zed\CompanyBusinessUnit\CompanyBusinessUnitConfig getConfig()
 */
class CompanyBusinessUnitBusinessFactory extends SprykerCompanyBusinessUnitBusinessFactory
{
    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitCreator\CompanyBusinessUnitCreatorInterface
     */
    public function createCompanyBusinessUnitCreator(): CompanyBusinessUnitCreatorInterface
    {
        return new CompanyBusinessUnitCreator(
            $this->getEntityManager(),
            $this->getConfig(),
            $this->createCompanyBusinessUnitPluginExecutor(),
            $this->getCompanyBusinessUnitFacade(),
        );
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface
     */
    protected function getCompanyBusinessUnitFacade(): CompanyBusinessUnitFacadeInterface
    {
        return $this->getProvidedDependency(CompanyBusinessUnitDependencyProvider::FACADE_COMPANY_BUSINESS_UNIT);
    }
}
