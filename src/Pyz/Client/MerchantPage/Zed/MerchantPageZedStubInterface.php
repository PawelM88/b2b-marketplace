<?php

namespace Pyz\Client\MerchantPage\Zed;

use Generated\Shared\Transfer\ContactFormResponseTransfer;
use Generated\Shared\Transfer\ContactFormTransfer;

interface MerchantPageZedStubInterface
{
    /**
     * @param \Generated\Shared\Transfer\ContactFormTransfer $contactFormTransfer
     *
     * @return \Generated\Shared\Transfer\ContactFormResponseTransfer
     */
    public function sendMessageToMerchant(ContactFormTransfer $contactFormTransfer): ContactFormResponseTransfer;
}
