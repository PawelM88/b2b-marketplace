<?php

namespace Pyz\Zed\CmsStorage\Business;

use Spryker\Zed\CmsStorage\Business\CmsStorageFacadeInterface as SprykerCmsStorageFacadeInterface;

interface CmsStorageFacadeInterface extends SprykerCmsStorageFacadeInterface
{
    /**
     * Specification:
     *  - Gets the url address for term based on idCmsPage
     *
     * @api
     *
     * @param int $idCmsPage
     *
     * @return string|null
     */
    public function getTermUrl(int $idCmsPage): ?string;
}
