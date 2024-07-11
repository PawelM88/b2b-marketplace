<?php

declare(strict_types=1);

namespace Pyz\Zed\CmsStorage\Business\CmsStorage;

use Pyz\Zed\CmsStorage\Persistence\CmsStorageRepositoryInterface;
use Spryker\Client\Locale\LocaleClientInterface;
use Spryker\Client\Store\StoreClientInterface;

class CmsStorageReader implements CmsStorageReaderInterface
{
    /**
     * @param \Pyz\Zed\CmsStorage\Persistence\CmsStorageRepositoryInterface $cmsStorageRepository
     * @param \Spryker\Client\Store\StoreClientInterface $storeClient
     * @param \Spryker\Client\Locale\LocaleClientInterface $localeClient
     */
    public function __construct(
        protected CmsStorageRepositoryInterface $cmsStorageRepository,
        protected StoreClientInterface $storeClient,
        protected LocaleClientInterface $localeClient,
    ) {
    }

    /**
     * @param int $idCmsPage
     *
     * @return string|null
     */
    public function getTermUrl(int $idCmsPage): ?string
    {
        $store = $this->storeClient->getCurrentStore()->getName();
        $locale = $this->localeClient->getCurrentLocale();

        $cmsStorageData = $this->cmsStorageRepository->getCmsStorageDataByIdCmsPage($idCmsPage, $store, $locale);

        if (!$cmsStorageData) {
            return null;
        }

        foreach ($cmsStorageData as $data) {
            $dataArray = $data->getData();

            if (isset($dataArray['url'])) {
                return $dataArray['url'];
            }
        }

        return null;
    }
}
