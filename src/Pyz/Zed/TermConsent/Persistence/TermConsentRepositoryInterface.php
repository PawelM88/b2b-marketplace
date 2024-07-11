<?php

namespace Pyz\Zed\TermConsent\Persistence;

use Generated\Shared\Transfer\TermResponseTransfer;

interface TermConsentRepositoryInterface
{
    /**
     * @param \Generated\Shared\Transfer\TermResponseTransfer $termResponseTransfer
     *
     * @return array<mixed>|null
     */
    public function findTermConsentCollectionByCustomerId(TermResponseTransfer $termResponseTransfer): ?array;
}
