<?php

namespace Pyz\Zed\Process\Business\Stream;

use Pyz\Zed\Process\Dependency\Plugin\Importer\DataImporterPluginInterface;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;
use SprykerMiddleware\Zed\Process\Business\Stream\StreamFactoryInterface as SprykerStreamFactoryInterface;

interface StreamFactoryInterface extends SprykerStreamFactoryInterface
{
    /**
     * @param \Pyz\Zed\Process\Dependency\Plugin\Importer\DataImporterPluginInterface $dataImporterPlugin
     *
     * @return \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface
     */
    public function createDataImportWriteStream(DataImporterPluginInterface $dataImporterPlugin): WriteStreamInterface;
}
