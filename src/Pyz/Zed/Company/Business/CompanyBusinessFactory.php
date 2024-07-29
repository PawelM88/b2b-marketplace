<?php

declare(strict_types=1);

namespace Pyz\Zed\Company\Business;

use Pyz\Zed\Company\Business\Model\Company;
use Pyz\Zed\Company\Business\Model\CompanyInterface;
use Pyz\Zed\Company\CompanyDependencyProvider;
use Spryker\Zed\Company\Business\CompanyBusinessFactory as SprykerCompanyBusinessFactory;
use Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface;

/**
 * @method \Pyz\Zed\Company\Persistence\CompanyEntityManagerInterface getEntityManager()
 * @method \Spryker\Zed\Company\Persistence\CompanyRepositoryInterface getRepository()
 * @method \Spryker\Zed\Company\CompanyConfig getConfig()
 */
class CompanyBusinessFactory extends SprykerCompanyBusinessFactory
{
    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Zed\Company\Business\Model\CompanyInterface
     */
    public function createCompany(): CompanyInterface
    {
        return new Company(
            $this->getRepository(),
            $this->getEntityManager(),
            $this->createPluginExecutor(),
            $this->createStoreRelationWriter(),
            $this->getCompanyRoleFacade(),
        );
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface
     */
    protected function getCompanyRoleFacade(): CompanyRoleFacadeInterface
    {
        return $this->getProvidedDependency(CompanyDependencyProvider::FACADE_COMPANY_ROLE);
    }
}
