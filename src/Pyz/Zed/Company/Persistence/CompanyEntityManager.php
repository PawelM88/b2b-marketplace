<?php

declare(strict_types=1);

namespace Pyz\Zed\Company\Persistence;

use Generated\Shared\Transfer\CompanyTransfer;
use Spryker\Zed\Company\Persistence\CompanyEntityManager as SprykerCompanyEntityManager;

/**
 * @method \Spryker\Zed\Company\Persistence\CompanyPersistenceFactory getFactory()
 */
class CompanyEntityManager extends SprykerCompanyEntityManager implements CompanyEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @throws \Propel\Runtime\Exception\PropelException !
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException !
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer
     */
    public function saveCompanyBasedOnDataFromCombinedCsvFile(CompanyTransfer $companyTransfer): CompanyTransfer
    {
        $spyCompany = $this->getFactory()
            ->createCompanyQuery()
            ->filterByKey($companyTransfer->getKey())
            ->findOneOrCreate();

        $isNew = $spyCompany->isNew();

        $spyCompany = $this->getFactory()
            ->createCompanyMapper()
            ->mapCompanyTransferToEntity($companyTransfer, $spyCompany);

        $spyCompany->save();

        $companyTransfer->fromArray($spyCompany->toArray(), true);
        $companyTransfer->setIsNew($isNew);

        return $companyTransfer;
    }
}
