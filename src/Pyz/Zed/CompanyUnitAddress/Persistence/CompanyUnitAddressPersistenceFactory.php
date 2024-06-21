<?php

declare(strict_types=1);

namespace Pyz\Zed\CompanyUnitAddress\Persistence;

use Pyz\Zed\CompanyUnitAddress\Persistence\Propel\Mapper\CompanyUnitAddressMapper;
use Pyz\Zed\CompanyUnitAddress\Persistence\Propel\Mapper\CompanyUnitAddressMapperInterface;
use Spryker\Zed\CompanyUnitAddress\Persistence\CompanyUnitAddressPersistenceFactory as SprykerCompanyUnitAddressPersistenceFactory;

/**
 * @method \Spryker\Zed\CompanyUnitAddress\Persistence\CompanyUnitAddressRepositoryInterface getRepository()
 * @method \Pyz\Zed\CompanyUnitAddress\Persistence\CompanyUnitAddressEntityManagerInterface getEntityManager()
 * @method \Spryker\Zed\CompanyUnitAddress\CompanyUnitAddressConfig getConfig()
 */
class CompanyUnitAddressPersistenceFactory extends SprykerCompanyUnitAddressPersistenceFactory
{
    /**
     * @return \Pyz\Zed\CompanyUnitAddress\Persistence\Propel\Mapper\CompanyUnitAddressMapperInterface
     */
    public function createCompanyUnitAddressMapper(): CompanyUnitAddressMapperInterface
    {
        return new CompanyUnitAddressMapper($this->createCountryMapper());
    }
}
