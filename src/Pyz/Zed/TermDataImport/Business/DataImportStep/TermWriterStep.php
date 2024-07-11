<?php

declare(strict_types=1);

namespace Pyz\Zed\TermDataImport\Business\DataImportStep;

use Orm\Zed\Cms\Persistence\SpyCmsPageQuery;
use Orm\Zed\Term\Persistence\PyzTermQuery;
use Pyz\Zed\TermDataImport\Business\DataSet\TermDataSetInterface;
use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

class TermWriterStep implements DataImportStepInterface
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
        $cmsPageEntity = SpyCmsPageQuery::create()
            ->filterByPageKey($dataSet[TermDataSetInterface::COLUMN_FK_CMS_PAGE])
            ->findOne();

        $cmsPageId = $cmsPageEntity->getIdCmsPage();

        $termEntity = PyzTermQuery::create()
            ->filterByTermKey($dataSet[TermDataSetInterface::COLUMN_TERM_KEY])
            ->findOneOrCreate();

        $termEntity->setTermKey($dataSet[TermDataSetInterface::COLUMN_TERM_KEY])
            ->setTermName($dataSet[TermDataSetInterface::COLUMN_NAME])
            ->setFkCmsPage($cmsPageId);

        if ($termEntity->isNew() || $termEntity->isModified()) {
            $termEntity->save();
        }
    }
}
