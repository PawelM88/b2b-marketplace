<?php

declare(strict_types=1);

namespace Pyz\Zed\MerchantOms\Communication\Plugin\Oms;

use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Pyz\Shared\Oms\MailSentStatusManager;
use Pyz\Zed\MerchantOms\Communication\Plugin\Mail\OrderShippedByMerchantMailTypeBuilderPlugin;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject;
use Spryker\Zed\Oms\Dependency\Plugin\Command\CommandByOrderInterface;

/**
 * @method \Pyz\Zed\MerchantOms\Communication\MerchantOmsCommunicationFactory getFactory()
 * @method \Spryker\Zed\MerchantOms\Business\MerchantOmsFacadeInterface getFacade()
 * @method \Pyz\Zed\MerchantOms\MerchantOmsConfig getConfig()
 */
class SendOrderShippedByMerchantMessagePlugin extends AbstractPlugin implements CommandByOrderInterface
{
    /**
     * {@inheritDoc}
     * - Sends a message informing that the order has been shipped by the merchant
     *
     * @api
     *
     * @param array<mixed> $orderItems
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     * @param \Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject $data
     *
     * @return array<empty>
     */
    public function run(array $orderItems, SpySalesOrder $orderEntity, ReadOnlyArrayObject $data): array
    {
        $mailSentStatusManager = MailSentStatusManager::getInstance();

        if (!$mailSentStatusManager::$mailSent) {
            $mailTypeBuilderPlugin = $this->getMailTypeBuilderPluginType();

            $this->getFactory()->getOmsFacade()->sendMessage($orderEntity, $mailTypeBuilderPlugin);

            $mailSentStatusManager::$mailSent = true;
        }

        return [];
    }

    /**
     * @return string
     */
    private function getMailTypeBuilderPluginType(): string
    {
        return OrderShippedByMerchantMailTypeBuilderPlugin::MAIL_TYPE;
    }
}
