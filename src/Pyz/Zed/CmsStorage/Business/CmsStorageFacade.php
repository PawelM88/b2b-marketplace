<?php

declare(strict_types=1);

namespace Pyz\Zed\CmsStorage\Business;

use Spryker\Zed\CmsStorage\Business\CmsStorageFacade as SprykerCmsStorageFacade;

/**
 * @method \Pyz\Zed\CmsStorage\Business\CmsStorageBusinessFactory getFactory()
 * @method \Pyz\Zed\CmsStorage\Persistence\CmsStorageRepositoryInterface getRepository()
 */
class CmsStorageFacade extends SprykerCmsStorageFacade implements CmsStorageFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $idCmsPage
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return string|null
     */
    public function getTermUrl(int $idCmsPage): ?string
    {
        return $this->getFactory()
            ->createCmsPageStorageReader()
            ->getTermUrl($idCmsPage);
    }
}
