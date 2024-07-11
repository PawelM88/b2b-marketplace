<?php

namespace Pyz\Zed\TermConsent\Business;

use Generated\Shared\Transfer\TermCollectionTransfer;
use Generated\Shared\Transfer\TermResponseTransfer;

interface TermConsentFacadeInterface
{
    /**
     * Specification:
     *  - Checks whether the user has accepted the required conditions
     *  - Returns those terms that were not accepted
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\TermResponseTransfer $termResponseTransfer
     *
     * @return \Generated\Shared\Transfer\TermResponseTransfer
     */
    public function hasCustomerAcceptedAllConsents(TermResponseTransfer $termResponseTransfer): TermResponseTransfer;

    /**
     * Specification:
     *  - Saves accepted terms into pyz_term_consent
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\TermCollectionTransfer $termCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\TermResponseTransfer
     */
    public function saveAcceptedTermConsentCollection(TermCollectionTransfer $termCollectionTransfer): TermResponseTransfer;
}
