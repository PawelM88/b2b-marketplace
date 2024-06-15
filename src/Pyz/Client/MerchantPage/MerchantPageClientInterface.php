<?php

namespace Pyz\Client\MerchantPage;

use Generated\Shared\Transfer\ContactFormResponseTransfer;
use Generated\Shared\Transfer\ContactFormTransfer;

interface MerchantPageClientInterface
{
    /**
     * Specification:
     * - Does Zed call.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ContactFormTransfer $contactFormTransfer
     *
     * @return \Generated\Shared\Transfer\ContactFormResponseTransfer
     */
    public function sendMessageToMerchant(ContactFormTransfer $contactFormTransfer): ContactFormResponseTransfer;
}
