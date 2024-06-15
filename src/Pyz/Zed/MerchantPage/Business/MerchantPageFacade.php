<?php

declare(strict_types=1);

namespace Pyz\Zed\MerchantPage\Business;

use Generated\Shared\Transfer\ContactFormResponseTransfer;
use Generated\Shared\Transfer\ContactFormTransfer;
use Generated\Shared\Transfer\MerchantProfileCriteriaTransfer;
use Generated\Shared\Transfer\MerchantProfileTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pyz\Zed\MerchantPage\Business\MerchantPageBusinessFactory getFactory()
 */
class MerchantPageFacade extends AbstractFacade implements MerchantPageFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\ContactFormTransfer $contactFormTransfer
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Generated\Shared\Transfer\ContactFormResponseTransfer
     */
    public function sendMessageToMerchant(ContactFormTransfer $contactFormTransfer): ContactFormResponseTransfer
    {
        return $this->getFactory()->createMailHandler()->sendMailToMerchant($contactFormTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantProfileCriteriaTransfer $merchantProfileCriteriaTransfer
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Generated\Shared\Transfer\MerchantProfileTransfer|null
     */
    public function findMerchant(MerchantProfileCriteriaTransfer $merchantProfileCriteriaTransfer): ?MerchantProfileTransfer
    {
        return $this->getFactory()->createMerchantFinder()->findMerchant($merchantProfileCriteriaTransfer);
    }
}
