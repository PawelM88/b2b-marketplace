<?php

declare(strict_types=1);

namespace Pyz\Client\CustomerPage\Zed;

use Generated\Shared\Transfer\TermCollectionTransfer;
use Generated\Shared\Transfer\TermResponseTransfer;
use Spryker\Client\ZedRequest\ZedRequestClientInterface;

class CustomerPageZedStub implements CustomerPageZedStubInterface
{
    /**
     * @param \Spryker\Client\ZedRequest\ZedRequestClientInterface $zedRequestClient
     */
    public function __construct(protected ZedRequestClientInterface $zedRequestClient)
    {
    }

    /**
     * @param \Generated\Shared\Transfer\TermResponseTransfer $termResponseTransfer
     *
     * @return \Generated\Shared\Transfer\TermResponseTransfer
     */
    public function hasCustomerAcceptedAllConsents(TermResponseTransfer $termResponseTransfer): TermResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\TermResponseTransfer $termResponseTransfer */
        $termResponseTransfer = $this->zedRequestClient->call('/term-consent/gateway/has-customer-accepted-all-consents', $termResponseTransfer);

        return $termResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\TermCollectionTransfer $termCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\TermResponseTransfer
     */
    public function saveAcceptedTermConsentCollection(TermCollectionTransfer $termCollectionTransfer): TermResponseTransfer
    {
        /** @var \Generated\Shared\Transfer\TermResponseTransfer $termResponseTransfer */
        $termResponseTransfer = $this->zedRequestClient->call('/term-consent/gateway/save-accepted-term-consent-collection', $termCollectionTransfer);

        return $termResponseTransfer;
    }
}
