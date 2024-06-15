<?php

declare(strict_types=1);

namespace Pyz\Zed\Oms\Business\Mail;

use Generated\Shared\Transfer\MailTransfer;
use Orm\Zed\Sales\Persistence\SpySalesOrder;
use Spryker\Zed\Oms\Business\Mail\MailHandler as SprykerMailHandler;

class MailHandler extends SprykerMailHandler
{
    /**
     * @param \Orm\Zed\Sales\Persistence\SpySalesOrder $orderEntity
     * @param string $mailTypeBuilderPlugin
     *
     * @return void
     */
    public function sendMail(SpySalesOrder $orderEntity, string $mailTypeBuilderPlugin): void
    {
        $orderTransfer = $this->getOrderTransfer($orderEntity);

        $mailTransfer = (new MailTransfer())
            ->setOrder($orderTransfer)
            ->setType($mailTypeBuilderPlugin)
            ->setLocale($orderTransfer->getLocale())
            ->setStoreName($orderEntity->getStore());

        $mailTransfer = $this->expandOrderMailTransfer($mailTransfer, $orderTransfer);

        $this->mailFacade->handleMail($mailTransfer);
    }
}
