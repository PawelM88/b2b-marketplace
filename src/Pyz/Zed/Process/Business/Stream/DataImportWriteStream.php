<?php

namespace Pyz\Zed\Process\Business\Stream;

use Pyz\Zed\Process\Dependency\Plugin\Importer\DataImporterPluginInterface;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;
use SprykerMiddleware\Zed\Process\Business\Exception\MethodNotSupportedException;

class DataImportWriteStream implements WriteStreamInterface
{
    /**
     * @var \Pyz\Zed\Process\Dependency\Plugin\Importer\DataImporterPluginInterface
     */
    protected DataImporterPluginInterface $dataImporterPlugin;

    /**
     * @var array
     */
    protected array $data = [];

    /**
     * @param \Pyz\Zed\Process\Dependency\Plugin\Importer\DataImporterPluginInterface $dataImporterPlugin
     */
    public function __construct(DataImporterPluginInterface $dataImporterPlugin)
    {
        $this->dataImporterPlugin = $dataImporterPlugin;
    }

    /**
     * @return bool
     */
    public function open(): bool
    {
        $this->data = [];
        return true;
    }

    /**
     * @return bool
     */
    public function close(): bool
    {
        return true;
    }

    /**
     * @param int $offset
     * @param int $whence
     *
     * @return int
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\MethodNotSupportedException
     *
     */
    public function seek(int $offset, int $whence): int
    {
        throw new MethodNotSupportedException();
    }

    /**
     * @return bool
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\MethodNotSupportedException
     *
     */
    public function eof(): bool
    {
        throw new MethodNotSupportedException();
    }

    /**
     * @param array $data
     *
     * @return int
     */
    public function write(array $data): int
    {
        $this->data[] = $data;
        return 1;
    }

    /**
     * @return bool
     */
    public function flush(): bool
    {
        $this->dataImporterPlugin->import($this->data);
        return true;
    }
}
