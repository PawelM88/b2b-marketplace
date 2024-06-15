<?php

declare(strict_types=1);

namespace Pyz\Zed\Oms\Communication\Plugin\Oms;

use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Pyz\Shared\Oms\MailSentStatusManager;
use Pyz\Zed\Oms\Communication\Plugin\Mail\CancelOrderMailTypeBuilderPlugin;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject;
use Spryker\Zed\Oms\Dependency\Plugin\Command\CommandByOrderInterface;

/**
 * @method \Pyz\Zed\Oms\Business\OmsFacadeInterface getFacade()
 * @method \Pyz\Zed\Oms\OmsConfig getConfig()
 * @method \Pyz\Zed\Oms\Communication\OmsCommunicationFactory getFactory()
 * @method \Spryker\Zed\Oms\Persistence\OmsQueryContainerInterface getQueryContainer()
 */
class SendCancelOrderMessagePlugin extends AbstractPlugin implements CommandByOrderInterface
{
    /**
     * {@inheritDoc}
     * - Sends a message informing about the cancellation of the order
     *
     * @api
     *
     * @param array<mixed> $orderItems
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     * @param \Spryker\Zed\Oms\Business\Util\ReadOnlyArrayObject $data
     *
     * @return array<mixed>
     */
    public function run(array $orderItems, SpySalesOrder $orderEntity, ReadOnlyArrayObject $data): array
    {
        $mailSentStatusManager = MailSentStatusManager::getInstance();

        if (!$mailSentStatusManager::$mailSent) {
            $mailTypeBuilderPlugin = $this->getMailTypeBuilderPluginType();

            $this->getFacade()->sendMessage($orderEntity, $mailTypeBuilderPlugin);

            $mailSentStatusManager::$mailSent = true;
        }

        return [];
    }

    /**
     * @return string
     */
    private function getMailTypeBuilderPluginType(): string
    {
        return CancelOrderMailTypeBuilderPlugin::MAIL_TYPE;
    }
}
