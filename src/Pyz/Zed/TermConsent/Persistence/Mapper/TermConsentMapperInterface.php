<?php

namespace Pyz\Zed\TermConsent\Persistence\Mapper;

use Generated\Shared\Transfer\MissingTermCollectionTransfer;
use Generated\Shared\Transfer\TermCollectionTransfer;

interface TermConsentMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\TermCollectionTransfer $termCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\MissingTermCollectionTransfer
     */
    public function mapAllNotConsentedTerms(TermCollectionTransfer $termCollectionTransfer): MissingTermCollectionTransfer;
}
