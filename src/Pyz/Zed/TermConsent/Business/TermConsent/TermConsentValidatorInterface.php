<?php

namespace Pyz\Zed\TermConsent\Business\TermConsent;

use Generated\Shared\Transfer\TermCollectionTransfer;
use Generated\Shared\Transfer\TermResponseTransfer;

interface TermConsentValidatorInterface
{
    /**
     * @param \Generated\Shared\Transfer\TermCollectionTransfer|null $termCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\TermResponseTransfer|null
     */
    public function validateTerms(?TermCollectionTransfer $termCollectionTransfer): ?TermResponseTransfer;

    /**
     * @param \Generated\Shared\Transfer\TermCollectionTransfer $termCollectionTransfer
     * @param array<mixed> $termConsentCollection
     * @param \Generated\Shared\Transfer\TermResponseTransfer $termResponseTransfer
     *
     * @return \Generated\Shared\Transfer\TermResponseTransfer
     */
    public function verifyAcceptedTermConsents(
        TermCollectionTransfer $termCollectionTransfer,
        array $termConsentCollection,
        TermResponseTransfer $termResponseTransfer,
    ): TermResponseTransfer;
}
