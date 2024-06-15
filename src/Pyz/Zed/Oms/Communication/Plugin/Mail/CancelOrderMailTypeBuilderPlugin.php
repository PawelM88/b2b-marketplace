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
class CancelOrderMailTypeBuilderPlugin extends AbstractMailTypeBuilderPlugin implements MailTypeBuilderPluginInterface
{
    /**
     * @var string
     */
    public const MAIL_TYPE = 'cancel order mail';

    /**
     * @var string
     */
    protected const GLOSSARY_KEY_MAIL_SUBJECT = 'mail.cancel.order.subject';

    /**
     * @var string
     */
    protected const MAIL_TEMPLATE_HTML = 'oms/mail/cancel.order.html.twig';

    /**
     * @var string
     */
    protected const MAIL_TEMPLATE_TEXT = 'oms/mail/cancel.order.text.twig';

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
