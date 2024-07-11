<?php

declare(strict_types=1);

namespace Pyz\Zed\TermConsent\Business\TermConsent;

use Generated\Shared\Transfer\TermCollectionTransfer;
use Generated\Shared\Transfer\TermResponseTransfer;
use Pyz\Zed\TermConsent\Persistence\TermConsentEntityManagerInterface;

class TermConsentSaver implements TermConsentSaverInterface
{
    /**
     * @param \Pyz\Zed\TermConsent\Persistence\TermConsentEntityManagerInterface $termConsentEntityManager
     */
    public function __construct(protected TermConsentEntityManagerInterface $termConsentEntityManager)
    {
    }

    /**
     * @param \Generated\Shared\Transfer\TermCollectionTransfer $termCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\TermResponseTransfer
     */
    public function saveAcceptedTermConsentCollection(TermCollectionTransfer $termCollectionTransfer): TermResponseTransfer
    {
        return $this->termConsentEntityManager->saveAcceptedTermConsentCollection($termCollectionTransfer);
    }
}
