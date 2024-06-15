<?php

declare(strict_types=1);

namespace Pyz\Client\MerchantPage\Zed;

use Generated\Shared\Transfer\ContactFormResponseTransfer;
use Generated\Shared\Transfer\ContactFormTransfer;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;

class MerchantPageZedStub implements MerchantPageZedStubInterface
{
    /**
     * @param \Spryker\Client\ZedRequest\ZedRequestClientInterface $zedRequestClient
     */
    public function __construct(protected ZedRequestClientInterface $zedRequestClient)
    {
    }

    /**
     * @param \Generated\Shared\Transfer\ContactFormTransfer $contactFormTransfer
     *
     * @return \Generated\Shared\Transfer\ContactFormResponseTransfer
     */
    public function sendMessageToMerchant(ContactFormTransfer $contactFormTransfer): ContactFormResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\ContactFormResponseTransfer $contactFormResponseTransfer */
        $contactFormResponseTransfer = $this->zedRequestClient->call('/merchant-page/gateway/send-message-to-merchant', $contactFormTransfer);

        return $contactFormResponseTransfer;
    }
}
