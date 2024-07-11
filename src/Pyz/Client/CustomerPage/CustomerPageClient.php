<?php

declare(strict_types=1);

namespace Pyz\Client\CustomerPage;

use Generated\Shared\Transfer\TermCollectionTransfer;
use Generated\Shared\Transfer\TermResponseTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \Pyz\Client\CustomerPage\CustomerPageFactory getFactory()
 */
class CustomerPageClient extends AbstractClient implements CustomerPageClientInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\TermResponseTransfer $termResponseTransfer
     *
     * @throws \Spryker\Client\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Generated\Shared\Transfer\TermResponseTransfer
     */
    public function hasCustomerAcceptedAllConsents(TermResponseTransfer $termResponseTransfer): TermResponseTransfer
    {
        return $this->getFactory()
            ->createCustomerPageZedStub()
            ->hasCustomerAcceptedAllConsents($termResponseTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\TermCollectionTransfer $termCollectionTransfer
     *
     * @throws \Spryker\Client\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Generated\Shared\Transfer\TermResponseTransfer
     */
    public function saveAcceptedTermConsentCollection(TermCollectionTransfer $termCollectionTransfer): TermResponseTransfer
    {
        return $this->getFactory()
            ->createCustomerPageZedStub()
            ->saveAcceptedTermConsentCollection($termCollectionTransfer);
    }
}
