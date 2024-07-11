<?php

declare(strict_types=1);

namespace Pyz\Zed\Term\Business\Term;

use Generated\Shared\Transfer\TermCollectionTransfer;
use Pyz\Zed\CmsStorage\Business\CmsStorageFacadeInterface;
use Pyz\Zed\Term\Persistence\Mapper\TermMapperInterface;
use Pyz\Zed\Term\Persistence\TermRepositoryInterface;

class TermReader implements TermReaderInterface
{
    /**
     * @param \Pyz\Zed\Term\Persistence\TermRepositoryInterface $termRepository
     * @param \Pyz\Zed\Term\Persistence\Mapper\TermMapperInterface $termMapper
     * @param \Pyz\Zed\CmsStorage\Business\CmsStorageFacadeInterface $cmsStorageFacade
     */
    public function __construct(
        protected TermRepositoryInterface $termRepository,
        protected TermMapperInterface $termMapper,
        protected CmsStorageFacadeInterface $cmsStorageFacade,
    ) {
    }

    /**
     * @return \Generated\Shared\Transfer\TermCollectionTransfer|null
     */
    public function getAllTerms(): ?TermCollectionTransfer
    {
        $termCollection = $this->termRepository->getAllTerms();

        if (!$termCollection) {
            return null;
        }

        $termCollectionTransfer = $this->termMapper->mapTermCollectionToTermCollectionTransfer($termCollection);

        foreach ($termCollectionTransfer->getTerms() as $term) {
            $termUrl = $this->cmsStorageFacade->getTermUrl($term->getFkCmsPage());

            if (!$termUrl) {
                return null;
            }

            $term->setTermUrl($termUrl);
        }

        return $termCollectionTransfer;
    }
}
