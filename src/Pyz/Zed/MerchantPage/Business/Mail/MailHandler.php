<?php

declare(strict_types=1);

namespace Pyz\Zed\MerchantPage\Business\Mail;

use Generated\Shared\Transfer\ContactFormResponseTransfer;
use Generated\Shared\Transfer\ContactFormTransfer;
use Generated\Shared\Transfer\MailTransfer;
use Pyz\Zed\MerchantPage\Communication\Plugin\Mail\ContactFormMailTypeBuilderPlugin;
use Spryker\Zed\Mail\Business\MailFacadeInterface;

class MailHandler
{
    /**
     * @param \Spryker\Zed\Mail\Business\MailFacadeInterface $mailFacade
     */
    public function __construct(protected MailFacadeInterface $mailFacade)
    {
    }

    /**
     * @param \Generated\Shared\Transfer\ContactFormTransfer $contactFormTransfer
     *
     * @return \Generated\Shared\Transfer\ContactFormResponseTransfer
     */
    public function sendMailToMerchant(ContactFormTransfer $contactFormTransfer): ContactFormResponseTransfer
    {
        $mailTransfer = (new MailTransfer())
            ->setContactForm($contactFormTransfer)
            ->setType(ContactFormMailTypeBuilderPlugin::MAIL_TYPE);

        $this->mailFacade->handleMail($mailTransfer);

        return (new ContactFormResponseTransfer())->setIsSuccess(true);
    }
}
