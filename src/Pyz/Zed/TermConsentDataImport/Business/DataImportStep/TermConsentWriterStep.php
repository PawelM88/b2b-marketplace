<?php

declare(strict_types=1);

namespace Pyz\Zed\TermConsentDataImport\Business\DataImportStep;

use Orm\Zed\Customer\Persistence\SpyCustomerQuery;
use Orm\Zed\Term\Persistence\PyzTermConsentQuery;
use Orm\Zed\Term\Persistence\PyzTermQuery;
use Pyz\Zed\TermConsentDataImport\Business\DataSet\TermConsentDataSetInterface;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

class TermConsentWriterStep implements DataImportStepInterface
{
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
        $termEntity = PyzTermQuery::create()
            ->filterByTermKey($dataSet[TermConsentDataSetInterface::COLUMN_TERM_KEY])
            ->findOne();

        $termId = $termEntity->getIdTerm();

        $customerEntity = SpyCustomerQuery::create()
            ->filterByCustomerReference($dataSet[TermConsentDataSetInterface::COLUMN_CUSTOMER_REFERENCE])
            ->findOne();

        $customerId = $customerEntity->getIdCustomer();

        $termConsentEntity = PyzTermConsentQuery::create()
            ->filterByFkTerm($termId)
            ->filterByFkCustomer($customerId)
            ->findOneOrCreate();

        if ($termConsentEntity->isNew() || $termConsentEntity->isModified()) {
            $termConsentEntity->save();
        }
    }
}
