<?php

declare(strict_types=1);

namespace Pyz\Zed\Term\Business;

use Generated\Shared\Transfer\TermCollectionTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pyz\Zed\Term\Business\TermBusinessFactory getFactory()
 * @method \Pyz\Zed\Term\Persistence\TermRepositoryInterface getRepository()
 */
class TermFacade extends AbstractFacade implements TermFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Generated\Shared\Transfer\TermCollectionTransfer|null
     */
    public function getAllTerms(): ?TermCollectionTransfer
    {
        return $this->getFactory()
            ->createTermReader()
            ->getAllTerms();
    }
}
