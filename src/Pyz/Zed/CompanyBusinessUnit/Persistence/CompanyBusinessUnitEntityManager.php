<?php

declare(strict_types=1);

namespace Pyz\Zed\CompanyBusinessUnit\Persistence;

use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Orm\Zed\CompanyBusinessUnit\Persistence\SpyCompanyBusinessUnit;
use Spryker\Zed\CompanyBusinessUnit\Persistence\CompanyBusinessUnitEntityManager as SprykerCompanyBusinessUnitEntityManager;

/**
 * @method \Pyz\Zed\CompanyBusinessUnit\Persistence\CompanyBusinessUnitPersistenceFactory getFactory()
 */
class CompanyBusinessUnitEntityManager extends SprykerCompanyBusinessUnitEntityManager implements
    CompanyBusinessUnitEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
     *
     * @throws \Propel\Runtime\Exception\PropelException !
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException !
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    public function saveCompanyBusinessUnitBasedOnDataFromCombinedCsvFile(
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer,
    ): CompanyBusinessUnitTransfer {
        $spyCompanyBusinessUnit = $this->findOrCreateCompanyBusinessUnitByKeyAndFkCompany(
            $companyBusinessUnitTransfer->getKey(),
            $companyBusinessUnitTransfer->getFkCompany(),
        );
        $isNew = $spyCompanyBusinessUnit->isNew();
        $isUpdated = true;

        $spyCompanyBusinessUnit = $this->mapCompanyBusinessUnitTransferToEntity(
            $companyBusinessUnitTransfer,
            $spyCompanyBusinessUnit,
        );

        if (!$spyCompanyBusinessUnit->getModifiedColumns()) {
            $isUpdated = false;
        }

        $spyCompanyBusinessUnit->save();

        $companyBusinessUnitTransfer->fromArray($spyCompanyBusinessUnit->toArray(), true);
        $companyBusinessUnitTransfer->setIsNew($isNew);
        $companyBusinessUnitTransfer->setIsUpdated($isUpdated);

        return $companyBusinessUnitTransfer;
    }

    /**
     * @param string $key
     * @param int $fkCompany
     *
     * @throws \Propel\Runtime\Exception\PropelException !
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException !
     *
     * @return \Orm\Zed\CompanyBusinessUnit\Persistence\SpyCompanyBusinessUnit
     */
    protected function findOrCreateCompanyBusinessUnitByKeyAndFkCompany(
        string $key,
        int $fkCompany,
    ): SpyCompanyBusinessUnit {
        return $this->getFactory()
            ->createCompanyBusinessUnitQuery()
            ->filterByKey($key)
            ->filterByFkCompany($fkCompany)
            ->findOneOrCreate();
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
     * @param \Orm\Zed\CompanyBusinessUnit\Persistence\SpyCompanyBusinessUnit $spyCompanyBusinessUnit
     *
     * @return \Orm\Zed\CompanyBusinessUnit\Persistence\SpyCompanyBusinessUnit
     */
    protected function mapCompanyBusinessUnitTransferToEntity(
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer,
        SpyCompanyBusinessUnit $spyCompanyBusinessUnit,
    ): SpyCompanyBusinessUnit {
        return $this->getFactory()
            ->createCompanyBusinessUnitMapper()
            ->mapCompanyBusinessUnitTransferToCompanyBusinessUnit(
                $companyBusinessUnitTransfer,
                $spyCompanyBusinessUnit,
            );
    }
}
