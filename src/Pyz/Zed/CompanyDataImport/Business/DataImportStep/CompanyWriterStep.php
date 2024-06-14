<?php

declare(strict_types=1);

namespace Pyz\Zed\CompanyDataImport\Business\DataImportStep;

use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Orm\Zed\Company\Persistence\SpyCompany;
use Orm\Zed\Company\Persistence\SpyCompanyQuery;
use Pyz\Zed\CompanyDataImport\Business\DataSet\CompanyDataSetInterface;
use Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

class CompanyWriterStep implements DataImportStepInterface
{
    /**
     * @param \Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface $companyRoleFacade
     */
    public function __construct(protected CompanyRoleFacadeInterface $companyRoleFacade)
    {
    }

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @throws \Propel\Runtime\Exception\PropelException !
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException !
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet): void
    {
        $companyEntity = SpyCompanyQuery::create()
            ->filterByKey($dataSet[CompanyDataSetInterface::COLUMN_KEY])
            ->findOneOrCreate();

        $companyEntity->fromArray($dataSet->getArrayCopy());

        if ($companyEntity->isNew()) {
            $companyEntity->save();
            $this->createPredefinedRolesForCompany($companyEntity);
        }

        if ($companyEntity->isModified()) {
            $companyEntity->save();
        }
    }

    /**
     * @param \Orm\Zed\Company\Persistence\SpyCompany $companyEntity
     *
     * @return void
     */
    private function createPredefinedRolesForCompany(SpyCompany $companyEntity): void
    {
        $companyTransfer = new CompanyTransfer();
        $companyTransfer->fromArray($companyEntity->toArray(), true);

        $companyResponseTransfer = new CompanyResponseTransfer();
        $companyResponseTransfer->setCompanyTransfer($companyTransfer);

        $this->companyRoleFacade->createByCompany($companyResponseTransfer);
    }
}
