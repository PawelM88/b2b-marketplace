<?php

declare(strict_types=1);

namespace Pyz\Zed\CompanyBusinessUnit\Persistence;

use Pyz\Zed\CompanyBusinessUnit\Persistence\Propel\Mapper\CompanyBusinessUnitMapper;
use Pyz\Zed\CompanyBusinessUnit\Persistence\Propel\Mapper\CompanyBusinessUnitMapperInterface;
use Spryker\Zed\CompanyBusinessUnit\Persistence\CompanyBusinessUnitPersistenceFactory as SprykerCompanyBusinessUnitPersistenceFactory;

/**
 * @method \Pyz\Zed\CompanyBusinessUnit\Persistence\CompanyBusinessUnitRepositoryInterface getRepository()
 * @method \Pyz\Zed\CompanyBusinessUnit\Persistence\CompanyBusinessUnitEntityManagerInterface getEntityManager()
 * @method \Spryker\Zed\CompanyBusinessUnit\CompanyBusinessUnitConfig getConfig()
 */
class CompanyBusinessUnitPersistenceFactory extends SprykerCompanyBusinessUnitPersistenceFactory
{
    /**
     * @return \Pyz\Zed\CompanyBusinessUnit\Persistence\Propel\Mapper\CompanyBusinessUnitMapperInterface
     */
    public function createCompanyBusinessUnitMapper(): CompanyBusinessUnitMapperInterface
    {
        return new CompanyBusinessUnitMapper();
    }
}
