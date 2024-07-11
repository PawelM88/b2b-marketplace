<?php

namespace Pyz\Zed\Term\Business;

use Generated\Shared\Transfer\TermCollectionTransfer;

interface TermFacadeInterface
{
    /**
     * Specification:
     *  - Gets all terms and returns as TermCollectionTransfer
     *  - If it doesn't find any terms, it returns null
     *
     * @api
     *
     * @return \Generated\Shared\Transfer\TermCollectionTransfer|null
     */
    public function getAllTerms(): ?TermCollectionTransfer;
}
