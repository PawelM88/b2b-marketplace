<?php

declare(strict_types=1);

namespace Pyz\Zed\CompanyBusinessUnit\Persistence;

use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Spryker\Zed\CompanyBusinessUnit\Persistence\CompanyBusinessUnitRepository as SprykerCompanyBusinessUnitRepository;

/**
 * @method \Pyz\Zed\CompanyBusinessUnit\Persistence\CompanyBusinessUnitPersistenceFactory getFactory()
 */
class CompanyBusinessUnitRepository extends SprykerCompanyBusinessUnitRepository implements
    CompanyBusinessUnitRepositoryInterface
{
    /**
     * @param string $companyBusinessUnitKey
     *
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException !
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    public function getCompanyBusinessUnitByKey(string $companyBusinessUnitKey): CompanyBusinessUnitTransfer
    {
        $spyCompanyBusinessUnit = $this->getFactory()
            ->createCompanyBusinessUnitQuery()
            ->filterByKey($companyBusinessUnitKey)
            ->findOne();

        return $this->getFactory()
            ->createCompanyBusinessUnitMapper()
            ->mapEntityToBusinessUnitTransfer($spyCompanyBusinessUnit, new CompanyBusinessUnitTransfer());
    }
}
