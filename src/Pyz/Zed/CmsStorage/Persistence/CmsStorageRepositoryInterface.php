<?php

namespace Pyz\Zed\CmsStorage\Persistence;

interface CmsStorageRepositoryInterface
{
    /**
     * @param int $idCmsPage
     * @param string $store
     * @param string $locale
     *
     * @return array<mixed>|null
     */
    public function getCmsStorageDataByIdCmsPage(int $idCmsPage, string $store, string $locale): ?array;
}
