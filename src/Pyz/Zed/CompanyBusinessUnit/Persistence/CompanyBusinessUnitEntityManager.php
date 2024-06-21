<?php

declare(strict_types=1);

namespace Pyz\Zed\CompanyBusinessUnit\Persistence;

use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Spryker\Zed\CompanyBusinessUnit\Persistence\CompanyBusinessUnitEntityManager as SprykerCompanyBusinessUnitEntityManager;

/**
 * @method \Pyz\Zed\CompanyBusinessUnit\Persistence\CompanyBusinessUnitPersistenceFactory getFactory()
 */
class CompanyBusinessUnitEntityManager extends SprykerCompanyBusinessUnitEntityManager implements CompanyBusinessUnitEntityManagerInterface
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
        $spyCompanyBusinessUnit = $this->getFactory()
            ->createCompanyBusinessUnitQuery()
            ->filterByKey($companyBusinessUnitTransfer->getKey())
            ->filterByFkCompany($companyBusinessUnitTransfer->getFkCompany())
            ->findOneOrCreate();

        $companyBusinessUnitMapper = $this->getFactory()
            ->createCompanyBusinessUnitMapper();

        $spyCompanyBusinessUnit = $companyBusinessUnitMapper
            ->mapCompanyBusinessUnitTransferToCompanyBusinessUnit($companyBusinessUnitTransfer, $spyCompanyBusinessUnit);

        $spyCompanyBusinessUnit->save();

        return $companyBusinessUnitMapper
            ->mapCompanyBusinessUnitToCompanyBusinessUnitTransfer($companyBusinessUnitTransfer, $spyCompanyBusinessUnit);
    }
}
