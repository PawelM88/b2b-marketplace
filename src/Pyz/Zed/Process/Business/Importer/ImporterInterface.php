<?php

namespace Pyz\Zed\Process\Business\Importer;

interface ImporterInterface
{
    /**
     * @param array $data
     *
     * @return void
     */
    public function import(array $data): void;
}
