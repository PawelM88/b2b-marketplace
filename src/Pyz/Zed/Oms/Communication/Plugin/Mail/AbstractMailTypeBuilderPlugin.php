<?php

declare(strict_types=1);

namespace Pyz\Zed\Oms\Communication\Plugin\Mail;

use Generated\Shared\Transfer\MailRecipientTransfer;
use Generated\Shared\Transfer\MailTemplateTransfer;
use Generated\Shared\Transfer\MailTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\MailExtension\Dependency\Plugin\MailTypeBuilderPluginInterface;

abstract class AbstractMailTypeBuilderPlugin extends AbstractPlugin implements MailTypeBuilderPluginInterface
{
    /**
     * - Specification
     * - Returns the subject of the mail for glossary.
     *
     * @api
     *
     * @return string
     */
    abstract protected function getGlossaryKeyMailSubject(): string;

    /**
     * - Specification
     * - Returns the name of the HTML template file.
     *
     * @api
     *
     * @return string
     */
    abstract protected function getMailHtmlTemplate(): string;

    /**
     * - Specification
     * - Returns the name of the text template file.
     *
     * @api
     *
     * @return string
     */
    abstract protected function getMailTextTemplate(): string;

    /**
     * {@inheritDoc}
     * - Builds the `MailTransfer` with data for a various types of mails.
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
        /** @var \Generated\Shared\Transfer\OrderTransfer $orderTransfer */
        $orderTransfer = $mailTransfer->getOrderOrFail();

        return $mailTransfer
            ->setSubject($this->getGlossaryKeyMailSubject())
            ->addTemplate(
                (new MailTemplateTransfer())
                    ->setName($this->getMailHtmlTemplate())
                    ->setIsHtml(true),
            )
            ->addTemplate(
                (new MailTemplateTransfer())
                    ->setName($this->getMailTextTemplate())
                    ->setIsHtml(false),
            )
            ->addRecipient(
                (new MailRecipientTransfer())
                    ->setEmail($orderTransfer->getEmailOrFail())
                    ->setName(sprintf('%s %s', $orderTransfer->getFirstName(), $orderTransfer->getLastName())),
            );
    }
}
