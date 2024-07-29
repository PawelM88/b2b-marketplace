<?php

namespace Pyz\Zed\CompanyUnitAddress\Business;

use Generated\Shared\Transfer\CompanyUnitAddressTransfer;
use Generated\Shared\Transfer\SpyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer;
use Spryker\Zed\CompanyUnitAddress\Business\CompanyUnitAddressFacadeInterface as SprykerCompanyUnitAddressFacadeInterface;

interface CompanyUnitAddressFacadeInterface extends SprykerCompanyUnitAddressFacadeInterface
{
    /**
     * Specification:
     * - Creates a new Company Unit Address
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyUnitAddressTransfer $companyUnitAddressTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUnitAddressTransfer
     */
    public function createCompanyUnitAddressBasedOnDataFromCombinedCsvFile(
        CompanyUnitAddressTransfer $companyUnitAddressTransfer,
    ): CompanyUnitAddressTransfer;

    /**
     * Specification:
     *  - Assigns Company Unit Address to Company Business Unit
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\SpyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer $spyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer
     *
     * @return void
     */
    public function saveAddressToBusinessUnitRelationFromCombinedCsvFile(
        SpyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer $spyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer,
    ): void;
}
