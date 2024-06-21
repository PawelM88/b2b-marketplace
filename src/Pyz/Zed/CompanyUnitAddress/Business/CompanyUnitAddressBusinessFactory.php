<?php

declare(strict_types=1);

namespace Pyz\Zed\CompanyUnitAddress\Business;

use Pyz\Zed\CompanyUnitAddress\Business\Model\CompanyUnitAddress;
use Pyz\Zed\CompanyUnitAddress\Business\Model\CompanyUnitAddressInterface;
use Spryker\Zed\CompanyUnitAddress\Business\CompanyUnitAddressBusinessFactory as SprykerCompanyUnitAddressBusinessFactory;

/**
 * @method \Spryker\Zed\CompanyUnitAddress\Persistence\CompanyUnitAddressRepositoryInterface getRepository()
 * @method \Pyz\Zed\CompanyUnitAddress\Persistence\CompanyUnitAddressEntityManagerInterface getEntityManager()
 * @method \Spryker\Zed\CompanyUnitAddress\CompanyUnitAddressConfig getConfig()
 */
class CompanyUnitAddressBusinessFactory extends SprykerCompanyUnitAddressBusinessFactory
{
    /**
     * @return \Pyz\Zed\CompanyUnitAddress\Business\Model\CompanyUnitAddressInterface
     */
    public function createCompanyUnitAddress(): CompanyUnitAddressInterface
    {
        return new CompanyUnitAddress(
            $this->getEntityManager(),
            $this->getCountryFacade(),
            $this->getLocaleFacade(),
            $this->getCompanyBusinessUnitFacade(),
            $this->createCompanyBusinessUnitAddressReader(),
            $this->createCompanyUnitAddressPluginExecutor(),
        );
    }
}
