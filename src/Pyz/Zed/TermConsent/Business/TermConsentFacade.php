<?php

declare(strict_types=1);

namespace Pyz\Zed\TermConsent\Business;

use Generated\Shared\Transfer\TermCollectionTransfer;
use Generated\Shared\Transfer\TermResponseTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pyz\Zed\TermConsent\Business\TermConsentBusinessFactory getFactory()
 * @method \Pyz\Zed\TermConsent\Persistence\TermConsentRepositoryInterface getRepository()
 * @method \Pyz\Zed\TermConsent\Persistence\TermConsentEntityManagerInterface getEntityManager()
 */
class TermConsentFacade extends AbstractFacade implements TermConsentFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\TermResponseTransfer $termResponseTransfer
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Generated\Shared\Transfer\TermResponseTransfer
     */
    public function hasCustomerAcceptedAllConsents(TermResponseTransfer $termResponseTransfer): TermResponseTransfer
    {
        return $this->getFactory()
            ->createTermConsentReader()
            ->hasCustomerAcceptedAllConsents($termResponseTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\TermCollectionTransfer $termCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\TermResponseTransfer
     */
    public function saveAcceptedTermConsentCollection(TermCollectionTransfer $termCollectionTransfer): TermResponseTransfer
    {
        return $this->getFactory()
            ->createTermConsentSaver()
            ->saveAcceptedTermConsentCollection($termCollectionTransfer);
    }
}
