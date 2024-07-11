<?php

declare(strict_types=1);

namespace Pyz\Zed\Term\Business;

use Pyz\Zed\CmsStorage\Business\CmsStorageFacadeInterface;
use Pyz\Zed\Term\Business\Term\TermReader;
use Pyz\Zed\Term\Business\Term\TermReaderInterface;
use Pyz\Zed\Term\Persistence\Mapper\TermMapper;
use Pyz\Zed\Term\Persistence\Mapper\TermMapperInterface;
use Pyz\Zed\Term\TermDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Pyz\Zed\Term\Persistence\TermRepositoryInterface getRepository()
 */
class TermBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Zed\Term\Business\Term\TermReaderInterface
     */
    public function createTermReader(): TermReaderInterface
    {
        return new TermReader(
            $this->getRepository(),
            $this->createTermMapper(),
            $this->getCmsStorageFacade(),
        );
    }

    /**
     * @return \Pyz\Zed\Term\Persistence\Mapper\TermMapperInterface
     */
    protected function createTermMapper(): TermMapperInterface
    {
        return new TermMapper();
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Zed\CmsStorage\Business\CmsStorageFacadeInterface
     */
    protected function getCmsStorageFacade(): CmsStorageFacadeInterface
    {
        return $this->getProvidedDependency(TermDependencyProvider::CMS_STORAGE_FACADE);
    }
}
