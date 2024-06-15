<?php

declare(strict_types=1);

namespace Pyz\Client\MerchantPage;

use Generated\Shared\Transfer\ContactFormResponseTransfer;
use Generated\Shared\Transfer\ContactFormTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \Pyz\Client\MerchantPage\MerchantPageFactory getFactory()
 */
class MerchantPageClient extends AbstractClient implements MerchantPageClientInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\ContactFormTransfer $contactFormTransfer
     *
     * @throws \Spryker\Client\Kernel\Exception\Container\ContainerKeyNotFoundException
     *
     * @return \Generated\Shared\Transfer\ContactFormResponseTransfer
     */
    public function sendMessageToMerchant(ContactFormTransfer $contactFormTransfer): ContactFormResponseTransfer
    {
        return $this->getFactory()
            ->createMerchantPageZedStub()
            ->sendMessageToMerchant($contactFormTransfer);
    }
}
