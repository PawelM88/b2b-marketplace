<?php

namespace Pyz\Zed\Process\Business\Importer;

interface ImporterInterface
{
    /**
     * @param array<mixed> $data
     *
     * @return void
     */
    public function import(array $data): void;
}
