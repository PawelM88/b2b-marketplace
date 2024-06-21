<?php

declare(strict_types=1);

namespace Pyz\Zed\CompanyUnitAddress\Business;

use Generated\Shared\Transfer\CompanyUnitAddressTransfer;
use Generated\Shared\Transfer\SpyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer;
use Spryker\Zed\CompanyUnitAddress\Business\CompanyUnitAddressFacade as SprykerCompanyUnitAddressFacade;

/**
 * @method \Pyz\Zed\CompanyUnitAddress\Business\CompanyUnitAddressBusinessFactory getFactory()
 * @method \Spryker\Zed\CompanyUnitAddress\Persistence\CompanyUnitAddressRepositoryInterface getRepository()
 * @method \Pyz\Zed\CompanyUnitAddress\Persistence\CompanyUnitAddressEntityManagerInterface getEntityManager()
 */
class CompanyUnitAddressFacade extends SprykerCompanyUnitAddressFacade implements CompanyUnitAddressFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUnitAddressTransfer $companyUnitAddressTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUnitAddressTransfer
     */
    public function createCompanyUnitAddressBasedOnDataFromCombinedCsvFile(
        CompanyUnitAddressTransfer $companyUnitAddressTransfer,
    ): CompanyUnitAddressTransfer {
        return $this->getFactory()->createCompanyUnitAddress()->createCompanyUnitAddressBasedOnDataFromCombinedCsvFile(
            $companyUnitAddressTransfer,
        );
    }

    /**
     * @param \Generated\Shared\Transfer\SpyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer $spyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer
     *
     * @return void
     */
    public function saveAddressToBusinessUnitRelationFromCombinedCsvFile(
        SpyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer $spyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer,
    ): void {
        $this->getFactory()->createCompanyUnitAddress()->saveAddressToBusinessUnitRelationFromCombinedCsvFile(
            $spyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer,
        );
    }
}
