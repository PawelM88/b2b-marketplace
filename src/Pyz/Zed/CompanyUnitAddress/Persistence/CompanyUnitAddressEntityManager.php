<?php

declare(strict_types=1);

namespace Pyz\Zed\CompanyUnitAddress\Persistence;

use Generated\Shared\Transfer\CompanyUnitAddressTransfer;
use Generated\Shared\Transfer\SpyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer;
use Spryker\Zed\CompanyUnitAddress\Persistence\CompanyUnitAddressEntityManager as SprykerCompanyUnitAddressEntityManager;

/**
 * @method \Pyz\Zed\CompanyUnitAddress\Persistence\CompanyUnitAddressPersistenceFactory getFactory()
 */
class CompanyUnitAddressEntityManager extends SprykerCompanyUnitAddressEntityManager implements
    CompanyUnitAddressEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyUnitAddressTransfer $companyUnitAddressTransfer
     *
     * @throws \Propel\Runtime\Exception\PropelException !
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException !
     *
     * @return \Generated\Shared\Transfer\CompanyUnitAddressTransfer
     */
    public function saveCompanyBusinessUnitBasedOnDataFromCombinedCsvFile(
        CompanyUnitAddressTransfer $companyUnitAddressTransfer,
    ): CompanyUnitAddressTransfer {
        $companyUnitAddressEntity = $this->getFactory()->createCompanyUnitAddressQuery()
            ->filterByKey($companyUnitAddressTransfer->getKey())
            ->filterByFkCompany($companyUnitAddressTransfer->getFkCompany())
            ->findOneOrCreate();

        $companyUnitAddressMapper = $this->getFactory()->createCompanyUnitAddressMapper();

        $companyUnitAddressEntity = $companyUnitAddressMapper
            ->mapCompanyUnitAddressTransferFromCombinedCsvFileToCompanyUnitAddressEntity(
                $companyUnitAddressTransfer,
                $companyUnitAddressEntity,
            );

        $companyUnitAddressEntity->save();

        return $companyUnitAddressMapper->mapCompanyUnitAddressEntityToCompanyUnitAddressTransferFromCombinedCsvFile(
            $companyUnitAddressEntity,
            $companyUnitAddressTransfer,
        );
    }

    /**
     * @param \Generated\Shared\Transfer\SpyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer $companyUnitAddressToCompanyBusinessUnitEntityTransfer
     *
     * @throws \Propel\Runtime\Exception\PropelException !
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException !
     *
     * @return void
     */
    public function saveAddressToBusinessUnitRelationFromCombinedCsvFile(
        SpyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer $companyUnitAddressToCompanyBusinessUnitEntityTransfer,
    ): void {
        $companyUnitAddressToCompanyBusinessUnitEntity = $this->getFactory(
        )->createCompanyUnitAddressToCompanyBusinessUnitQuery()
            ->filterByFkCompanyBusinessUnit(
                $companyUnitAddressToCompanyBusinessUnitEntityTransfer->getFkCompanyBusinessUnit(),
            )
            ->filterByFkCompanyUnitAddress(
                $companyUnitAddressToCompanyBusinessUnitEntityTransfer->getFkCompanyUnitAddress(),
            )
            ->findOneOrCreate();

        $companyUnitAddressToCompanyBusinessUnitEntity = $this->getFactory()->createCompanyUnitAddressMapper(
        )->mapAddressToBusinessUnitEntityTransferToAddressToBusinessUnitEntity(
            $companyUnitAddressToCompanyBusinessUnitEntityTransfer,
            $companyUnitAddressToCompanyBusinessUnitEntity,
        );

        $companyUnitAddressToCompanyBusinessUnitEntity->save();
    }
}
