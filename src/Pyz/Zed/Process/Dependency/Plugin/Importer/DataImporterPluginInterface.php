<?php

namespace Pyz\Zed\Process\Dependency\Plugin\Importer;

interface DataImporterPluginInterface
{
    /**
     * @param array<mixed> $data
     *
     * @return void
     */
    public function import(array $data): void;
}
