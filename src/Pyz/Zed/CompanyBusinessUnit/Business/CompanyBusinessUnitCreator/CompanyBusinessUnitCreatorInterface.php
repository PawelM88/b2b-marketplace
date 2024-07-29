<?php

namespace Pyz\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitCreator;

use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitCreator\CompanyBusinessUnitCreatorInterface as SprykerCompanyBusinessUnitCreatorInterface;

interface CompanyBusinessUnitCreatorInterface extends SprykerCompanyBusinessUnitCreatorInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    public function createCompanyBusinessUnitBasedOnDataFromCombinedCsvFile(
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer,
    ): CompanyBusinessUnitTransfer;
}
