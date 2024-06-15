<?php

declare(strict_types=1);

namespace Pyz\Zed\MerchantPage\Communication\Plugin\Mail;

use Generated\Shared\Transfer\MailRecipientTransfer;
use Generated\Shared\Transfer\MailTemplateTransfer;
use Generated\Shared\Transfer\MailTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\MailExtension\Dependency\Plugin\MailTypeBuilderPluginInterface;

/**
 * @method \Pyz\Zed\MerchantPage\Business\MerchantPageFacadeInterface getFacade()
 * @method \Pyz\Zed\MerchantPage\MerchantPageConfig getConfig()
 */
class ContactFormMailTypeBuilderPlugin extends AbstractPlugin implements MailTypeBuilderPluginInterface
{
    /**
     * @var string
     */
    public const MAIL_TYPE = 'contact form mail';

    /**
     * @var string
     */
    protected const GLOSSARY_KEY_MAIL_SUBJECT = 'mail.contact_form.subject';

    /**
     * @var string
     */
    protected const MAIL_TEMPLATE_HTML = 'merchantPage/mail/contact_form.html.twig';

    /**
     * @var string
     */
    protected const MAIL_TEMPLATE_TEXT = 'merchantPage/mail/contact_form.text.twig';

    /**
     * {@inheritDoc}
     * - Returns the name of mail for an order shipped mail.
     *
     * @api
     *
     * @return string
     */
    public function getName(): string
    {
        return static::MAIL_TYPE;
    }

    /**
     * {@inheritDoc}
     * - Builds the `MailTransfer` with data.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\MailTransfer $mailTransfer
     *
     * @throws \Spryker\Shared\Kernel\Transfer\Exception\NullValueException
     *
     * @return \Generated\Shared\Transfer\MailTransfer
     */
    public function build(MailTransfer $mailTransfer): MailTransfer
    {
        return $mailTransfer
            ->setSubject(static::GLOSSARY_KEY_MAIL_SUBJECT)
            ->addTemplate(
                (new MailTemplateTransfer())
                    ->setName(static::MAIL_TEMPLATE_HTML)
                    ->setIsHtml(true),
            )
            ->addTemplate(
                (new MailTemplateTransfer())
                    ->setName(static::MAIL_TEMPLATE_TEXT)
                    ->setIsHtml(false),
            )
            ->addRecipient(
                (new MailRecipientTransfer())
                    ->setEmail($mailTransfer->getContactForm()->getMerchantEmailOrFail())
                    ->setName($mailTransfer->getContactForm()->getMerchantName()),
            );
    }
}
