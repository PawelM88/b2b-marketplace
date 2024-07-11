<?php

namespace Pyz\Client\CustomerPage;

use Generated\Shared\Transfer\TermCollectionTransfer;
use Generated\Shared\Transfer\TermResponseTransfer;

interface CustomerPageClientInterface
{
    /**
     * Specification:
     * - Does Zed call.
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
     * - Does Zed call.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\TermCollectionTransfer $termCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\TermResponseTransfer
     */
    public function saveAcceptedTermConsentCollection(TermCollectionTransfer $termCollectionTransfer): TermResponseTransfer;
}
