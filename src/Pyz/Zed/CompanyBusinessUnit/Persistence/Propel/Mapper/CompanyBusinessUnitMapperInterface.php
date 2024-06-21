<?php

namespace Pyz\Zed\CompanyBusinessUnit\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Orm\Zed\CompanyBusinessUnit\Persistence\Base\SpyCompanyBusinessUnit;
use Spryker\Zed\CompanyBusinessUnit\Persistence\Propel\Mapper\CompanyBusinessUnitMapperInterface as SprykerCompanyBusinessUnitMapperInterface;

interface CompanyBusinessUnitMapperInterface extends SprykerCompanyBusinessUnitMapperInterface
{
    /**
     * @param \Orm\Zed\CompanyBusinessUnit\Persistence\Base\SpyCompanyBusinessUnit $spyCompanyBusinessUnit
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    public function mapEntityToBusinessUnitTransfer(
        SpyCompanyBusinessUnit $spyCompanyBusinessUnit,
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer,
    ): CompanyBusinessUnitTransfer;

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
     * @param \Orm\Zed\CompanyBusinessUnit\Persistence\Base\SpyCompanyBusinessUnit $spyCompanyBusinessUnit
     *
     * @return \Orm\Zed\CompanyBusinessUnit\Persistence\Base\SpyCompanyBusinessUnit
     */
    public function mapCompanyBusinessUnitTransferToCompanyBusinessUnit(
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer,
        SpyCompanyBusinessUnit $spyCompanyBusinessUnit,
    ): SpyCompanyBusinessUnit;

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
     * @param \Orm\Zed\CompanyBusinessUnit\Persistence\Base\SpyCompanyBusinessUnit $spyCompanyBusinessUnit
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    public function mapCompanyBusinessUnitToCompanyBusinessUnitTransfer(
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer,
        SpyCompanyBusinessUnit $spyCompanyBusinessUnit,
    ): CompanyBusinessUnitTransfer;
}
