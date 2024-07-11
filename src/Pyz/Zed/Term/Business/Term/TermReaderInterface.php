<?php

namespace Pyz\Zed\Term\Business\Term;

use Generated\Shared\Transfer\TermCollectionTransfer;

interface TermReaderInterface
{
    /**
     * @return \Generated\Shared\Transfer\TermCollectionTransfer|null
     */
    public function getAllTerms(): ?TermCollectionTransfer;
}
