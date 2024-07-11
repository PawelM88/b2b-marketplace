<?php

declare(strict_types=1);

namespace Pyz\Zed\TermConsent\Persistence\Mapper;

use Generated\Shared\Transfer\MissingTermCollectionTransfer;
use Generated\Shared\Transfer\TermCollectionTransfer;

class TermConsentMapper implements TermConsentMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\TermCollectionTransfer $termCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\MissingTermCollectionTransfer
     */
    public function mapAllNotConsentedTerms(TermCollectionTransfer $termCollectionTransfer): MissingTermCollectionTransfer
    {
        $missingTermCollectionTransfer = new MissingTermCollectionTransfer();

        foreach ($termCollectionTransfer->getTerms() as $term) {
            $missingTermCollectionTransfer->addTerm($term);
        }

        return $missingTermCollectionTransfer;
    }
}
