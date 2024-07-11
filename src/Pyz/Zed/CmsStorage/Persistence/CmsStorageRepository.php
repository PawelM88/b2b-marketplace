<?php

declare(strict_types=1);

namespace Pyz\Zed\CmsStorage\Persistence;

use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \Spryker\Zed\CmsStorage\Persistence\CmsStoragePersistenceFactory getFactory()
 */
class CmsStorageRepository extends AbstractRepository implements CmsStorageRepositoryInterface
{
    /**
     * @param int $idCmsPage
     * @param string $store
     * @param string $locale
     *
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException !
     *
     * @return array<mixed>|null
     */
    public function getCmsStorageDataByIdCmsPage(int $idCmsPage, string $store, string $locale): ?array
    {
        $cmsStorageData = $this->getFactory()->createSpyCmsStorageQuery()
            ->filterByFkCmsPage($idCmsPage)
            ->filterByStore($store)
            ->filterByLocale($locale)
            ->findByFkCmsPage($idCmsPage)->getData();

        if (!$cmsStorageData) {
            return null;
        }

        return $cmsStorageData;
    }
}
