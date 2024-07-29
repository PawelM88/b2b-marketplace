<?php

namespace Pyz\Zed\CompanyBusinessUnit\Business;

use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface as SprykerCompanyBusinessUnitFacadeInterface;

interface CompanyBusinessUnitFacadeInterface extends SprykerCompanyBusinessUnitFacadeInterface
{
    /**
     * Specification:
     *  - Creates a new Company Business Unit
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    public function createCompanyBusinessUnitBasedOnDataFromCombinedCsvFile(
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer,
    ): CompanyBusinessUnitTransfer;

    /**
     * Specification:
     *  - Retrieve Company Business Unit by its key
     *
     * @api
     *
     * @param string $companyBusinessUnitKey
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    public function getCompanyBusinessUnitByKey(string $companyBusinessUnitKey): CompanyBusinessUnitTransfer;
}
