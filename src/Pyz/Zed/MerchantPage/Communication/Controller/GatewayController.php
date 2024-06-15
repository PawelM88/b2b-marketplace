<?php

declare(strict_types=1);

namespace Pyz\Zed\MerchantPage\Communication\Controller;

use Generated\Shared\Transfer\ContactFormResponseTransfer;
use Generated\Shared\Transfer\ContactFormTransfer;
use Generated\Shared\Transfer\MerchantProfileCriteriaTransfer;
use Pyz\Zed\MerchantPage\MerchantPageConfig;
use Spryker\Zed\Kernel\Communication\Controller\AbstractGatewayController;

/**
 * @method \Pyz\Zed\MerchantPage\Business\MerchantPageFacadeInterface getFacade()
 */
class GatewayController extends AbstractGatewayController
{
    /**
     * @param \Generated\Shared\Transfer\ContactFormTransfer $contactFormTransfer
     *
     * @return \Generated\Shared\Transfer\ContactFormResponseTransfer
     */
    public function sendMessageToMerchantAction(ContactFormTransfer $contactFormTransfer): ContactFormResponseTransfer
    {
        if ($this->validateMerchant($contactFormTransfer) === false) {
            return (new ContactFormResponseTransfer())
                ->setIsSuccess(false)
                ->setErrorMessage(MerchantPageConfig::NO_MERCHANT_ENTITY);
        }

        return $this->getFacade()->sendMessageToMerchant($contactFormTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ContactFormTransfer $contactFormTransfer
     *
     * @return bool
     */
    protected function validateMerchant(ContactFormTransfer $contactFormTransfer): bool
    {
        $merchantProfileCriteriaTransfer = new MerchantProfileCriteriaTransfer();
        $merchantProfileCriteriaTransfer->setMerchantReference(
            $contactFormTransfer->getMerchantProfileCriteria()->getMerchantReference(),
        );

        $merchantProfile = $this->getFacade()->findMerchant($merchantProfileCriteriaTransfer);

        if ($merchantProfile && $merchantProfile->getPublicEmail() === $contactFormTransfer->getMerchantEmail()) {
            return true;
        }

        return false;
    }
}
