<?php

namespace Pyz\Zed\TermConsent\Business\TermConsent;

use Generated\Shared\Transfer\TermCollectionTransfer;
use Generated\Shared\Transfer\TermResponseTransfer;

interface TermConsentSaverInterface
{
    /**
     * @param \Generated\Shared\Transfer\TermCollectionTransfer $termCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\TermResponseTransfer
     */
    public function saveAcceptedTermConsentCollection(TermCollectionTransfer $termCollectionTransfer): TermResponseTransfer;
}
