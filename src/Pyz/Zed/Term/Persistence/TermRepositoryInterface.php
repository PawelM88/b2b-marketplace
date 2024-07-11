<?php

namespace Pyz\Zed\Term\Persistence;

interface TermRepositoryInterface
{
    /**
     * @return array<mixed>|null
     */
    public function getAllTerms(): ?array;
}
