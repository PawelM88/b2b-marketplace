<?php

namespace Pyz\Zed\TermConsent\Business\TermConsent;

use Generated\Shared\Transfer\TermResponseTransfer;

interface TermConsentReaderInterface
{
    /**
     * @param \Generated\Shared\Transfer\TermResponseTransfer $termResponseTransfer
     *
     * @return \Generated\Shared\Transfer\TermResponseTransfer
     */
    public function hasCustomerAcceptedAllConsents(TermResponseTransfer $termResponseTransfer): TermResponseTransfer;
}
