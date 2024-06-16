<?php

declare(strict_types=1);

namespace Pyz\Zed\Process\Business\Stream;

use Pyz\Zed\Process\Dependency\Plugin\Importer\DataImporterPluginInterface;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;
use SprykerMiddleware\Zed\Process\Business\Stream\StreamFactory as SprykerStreamFactory;

class StreamFactory extends SprykerStreamFactory implements StreamFactoryInterface
{
    /**
     * @param \Pyz\Zed\Process\Dependency\Plugin\Importer\DataImporterPluginInterface $dataImporterPlugin
     *
     * @return \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface
     */
    public function createDataImportWriteStream(DataImporterPluginInterface $dataImporterPlugin): WriteStreamInterface
    {
        return new DataImportWriteStream($dataImporterPlugin);
    }
}
