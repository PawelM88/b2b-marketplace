<?php

declare(strict_types=1);

namespace Pyz\Zed\MerchantOms\Communication\Plugin\Mail;

use Pyz\Zed\Oms\Communication\Plugin\Mail\AbstractMailTypeBuilderPlugin;
use Spryker\Zed\MailExtension\Dependency\Plugin\MailTypeBuilderPluginInterface;

/**
 * @method \Spryker\Zed\MerchantOms\Business\MerchantOmsFacadeInterface getFacade()
 * @method \Pyz\Zed\MerchantOms\MerchantOmsConfig getConfig()
 * @method \Pyz\Zed\MerchantOms\Communication\MerchantOmsCommunicationFactory getFactory()
 */
class OrderShippedByMerchantMailTypeBuilderPlugin extends AbstractMailTypeBuilderPlugin implements MailTypeBuilderPluginInterface
{
    /**
     * @var string
     */
    public const MAIL_TYPE = 'order shipped by merchant mail';

    /**
     * @var string
     */
    protected const GLOSSARY_KEY_MAIL_SUBJECT = 'mail.order.shipped.by.merchant.subject';

    /**
     * @var string
     */
    protected const MAIL_TEMPLATE_HTML = 'merchantOms/mail/order_shipped_by_merchant.html.twig';

    /**
     * @var string
     */
    protected const MAIL_TEMPLATE_TEXT = 'merchantOms/mail/order_shipped_by_merchant.text.twig';

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
