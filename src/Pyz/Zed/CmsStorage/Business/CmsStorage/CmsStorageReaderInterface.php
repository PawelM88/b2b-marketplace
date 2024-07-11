<?php

namespace Pyz\Zed\CmsStorage\Business\CmsStorage;

interface CmsStorageReaderInterface
{
    /**
     * @param int $idCmsPage
     *
     * @return string|null
     */
    public function getTermUrl(int $idCmsPage): ?string;
}
