<?php

namespace Pyz\Zed\CompanyBusinessUnit\Persistence;

use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Spryker\Zed\CompanyBusinessUnit\Persistence\CompanyBusinessUnitEntityManagerInterface as SprykerCompanyBusinessUnitEntityManagerInterface;

interface CompanyBusinessUnitEntityManagerInterface extends SprykerCompanyBusinessUnitEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    public function saveCompanyBusinessUnitBasedOnDataFromCombinedCsvFile(
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer,
    ): CompanyBusinessUnitTransfer;
}
