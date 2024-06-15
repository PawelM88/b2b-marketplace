<?php

namespace Pyz\Zed\MerchantPage\Business;

use Generated\Shared\Transfer\ContactFormResponseTransfer;
use Generated\Shared\Transfer\ContactFormTransfer;
use Generated\Shared\Transfer\MerchantProfileCriteriaTransfer;
use Generated\Shared\Transfer\MerchantProfileTransfer;

interface MerchantPageFacadeInterface
{
    /**
     * Specification:
     * - Sends user data to MailHandler after filling out a form in Yves
     *
     * @param \Generated\Shared\Transfer\ContactFormTransfer $contactFormTransfer
     *
     * @return \Generated\Shared\Transfer\ContactFormResponseTransfer
     */
    public function sendMessageToMerchant(ContactFormTransfer $contactFormTransfer): ContactFormResponseTransfer;

    /**
     * Specification:
     * - Checks whether a merchant with the given reference exists in the database
     *
     * @param \Generated\Shared\Transfer\MerchantProfileCriteriaTransfer $merchantProfileCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantProfileTransfer|null
     */
    public function findMerchant(MerchantProfileCriteriaTransfer $merchantProfileCriteriaTransfer): ?MerchantProfileTransfer;
}
