<?php

declare(strict_types=1);

namespace Pyz\Zed\TermConsent\Communication\Controller;

use Generated\Shared\Transfer\TermCollectionTransfer;
use Generated\Shared\Transfer\TermResponseTransfer;
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;

/**
 * @method \Pyz\Zed\TermConsent\Business\TermConsentFacadeInterface getFacade()
 * @method \Pyz\Zed\TermConsent\Persistence\TermConsentRepositoryInterface getRepository()
 */
class GatewayController extends AbstractGatewayController
{
    /**
     * @param \Generated\Shared\Transfer\TermResponseTransfer $termResponseTransfer
     *
     * @return \Generated\Shared\Transfer\TermResponseTransfer
     */
    public function hasCustomerAcceptedAllConsentsAction(TermResponseTransfer $termResponseTransfer): TermResponseTransfer
    {
        return $this->getFacade()->hasCustomerAcceptedAllConsents($termResponseTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\TermCollectionTransfer $termCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\TermResponseTransfer
     */
    public function saveAcceptedTermConsentCollectionAction(TermCollectionTransfer $termCollectionTransfer): TermResponseTransfer
    {
        return $this->getFacade()->saveAcceptedTermConsentCollection($termCollectionTransfer);
    }
}
