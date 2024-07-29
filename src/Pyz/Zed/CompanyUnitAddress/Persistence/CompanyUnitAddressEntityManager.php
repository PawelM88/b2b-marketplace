<?php

declare(strict_types=1);

namespace Pyz\Zed\CompanyUnitAddress\Persistence;

use Generated\Shared\Transfer\CompanyUnitAddressTransfer;
use Generated\Shared\Transfer\SpyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer;
use Orm\Zed\CompanyUnitAddress\Persistence\SpyCompanyUnitAddress;
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
    public function saveCompanyUnitAddressBasedOnDataFromCombinedCsvFile(
        CompanyUnitAddressTransfer $companyUnitAddressTransfer,
    ): CompanyUnitAddressTransfer {
        $spyCompanyUnitAddress = $this->findOrCreateCompanyUnitAddressByKey(
            $companyUnitAddressTransfer->getKey(),
        );
        $isNew = $spyCompanyUnitAddress->isNew();
        $isUpdated = true;

        $spyCompanyUnitAddress = $this->mapCompanyUnitTransferToEntity(
            $companyUnitAddressTransfer,
            $spyCompanyUnitAddress,
        );

        if (!$spyCompanyUnitAddress->getModifiedColumns()) {
            $isUpdated = false;
        }

        $spyCompanyUnitAddress->save();

        $companyUnitAddressTransfer->fromArray($spyCompanyUnitAddress->toArray(), true);
        $companyUnitAddressTransfer->setIsNew($isNew);
        $companyUnitAddressTransfer->setIsUpdated($isUpdated);

        return $companyUnitAddressTransfer;
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

    /**
     * @param string $key
     *
     * @throws \Propel\Runtime\Exception\PropelException !
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException !
     *
     * @return \Orm\Zed\CompanyUnitAddress\Persistence\SpyCompanyUnitAddress
     */
    protected function findOrCreateCompanyUnitAddressByKey(
        string $key,
    ): SpyCompanyUnitAddress {
        return $this->getFactory()->createCompanyUnitAddressQuery()
            ->filterByKey($key)
            ->findOneOrCreate();
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUnitAddressTransfer $companyUnitAddressTransfer
     * @param \Orm\Zed\CompanyUnitAddress\Persistence\SpyCompanyUnitAddress $spyCompanyUnitAddress
     *
     * @return \Orm\Zed\CompanyUnitAddress\Persistence\SpyCompanyUnitAddress
     */
    protected function mapCompanyUnitTransferToEntity(
        CompanyUnitAddressTransfer $companyUnitAddressTransfer,
        SpyCompanyUnitAddress $spyCompanyUnitAddress,
    ): SpyCompanyUnitAddress {
        return $this->getFactory()->createCompanyUnitAddressMapper()
            ->mapCompanyUnitAddressTransferFromCombinedCsvFileToCompanyUnitAddressEntity(
                $companyUnitAddressTransfer,
                $spyCompanyUnitAddress,
            );
    }
}
