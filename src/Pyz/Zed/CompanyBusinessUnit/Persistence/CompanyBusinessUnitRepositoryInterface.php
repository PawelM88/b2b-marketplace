<?php

namespace Pyz\Zed\CompanyBusinessUnit\Persistence;

use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Spryker\Zed\CompanyBusinessUnit\Persistence\CompanyBusinessUnitRepositoryInterface as SprykerCompanyBusinessUnitRepositoryInterface;

interface CompanyBusinessUnitRepositoryInterface extends SprykerCompanyBusinessUnitRepositoryInterface
{
    /**
     * @param string $companyBusinessUnitKey
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    public function getCompanyBusinessUnitByKey(string $companyBusinessUnitKey): CompanyBusinessUnitTransfer;
}
