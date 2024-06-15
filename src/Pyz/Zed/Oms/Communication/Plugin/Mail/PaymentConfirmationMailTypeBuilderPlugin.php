<?php

declare(strict_types=1);

namespace Pyz\Zed\Oms\Communication\Plugin\Mail;

use Spryker\Zed\MailExtension\Dependency\Plugin\MailTypeBuilderPluginInterface;

/**
 * @method \Pyz\Zed\Oms\Business\OmsFacadeInterface getFacade()
 * @method \Pyz\Zed\Oms\OmsConfig getConfig()
 * @method \Pyz\Zed\Oms\Communication\OmsCommunicationFactory getFactory()
 * @method \Spryker\Zed\Oms\Persistence\OmsQueryContainerInterface getQueryContainer()
 */
class PaymentConfirmationMailTypeBuilderPlugin extends AbstractMailTypeBuilderPlugin implements MailTypeBuilderPluginInterface
{
    /**
     * @var string
     */
    public const MAIL_TYPE = 'payment confirmation mail';

    /**
     * @var string
     */
    protected const GLOSSARY_KEY_MAIL_SUBJECT = 'mail.payment.confirmation.subject';

    /**
     * @var string
     */
    protected const MAIL_TEMPLATE_HTML = 'oms/mail/payment_confirmation.html.twig';

    /**
     * @var string
     */
    protected const MAIL_TEMPLATE_TEXT = 'oms/mail/payment_confirmation.text.twig';

    /**
     * {@inheritDoc}
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
     *
     * @api
     *
     * @return string
     */
    protected function getGlossaryKeyMailSubject(): string
    {
        return static::GLOSSARY_KEY_MAIL_SUBJECT;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    protected function getMailHtmlTemplate(): string
    {
        return static::MAIL_TEMPLATE_HTML;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    protected function getMailTextTemplate(): string
    {
        return static::MAIL_TEMPLATE_TEXT;
    }
}
