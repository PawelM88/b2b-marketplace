<?php

namespace Pyz\Zed\Term\Persistence\Mapper;

use Generated\Shared\Transfer\TermCollectionTransfer;

interface TermMapperInterface
{
    /**
     * @param array<\Generated\Shared\Transfer\TermCollectionTransfer> $termCollection
     *
     * @return \Generated\Shared\Transfer\TermCollectionTransfer
     */
    public function mapTermCollectionToTermCollectionTransfer(array $termCollection): TermCollectionTransfer;
}
