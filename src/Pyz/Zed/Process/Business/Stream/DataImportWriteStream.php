<?php

declare(strict_types=1);

namespace Pyz\Zed\Process\Business\Stream;

use Pyz\Zed\Process\Dependency\Plugin\Importer\DataImporterPluginInterface;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;
use SprykerMiddleware\Zed\Process\Business\Exception\MethodNotSupportedException;

class DataImportWriteStream implements WriteStreamInterface
{
    /**
     * @var array<mixed>
     */
    protected array $data = [];

    /**
     * @param \Pyz\Zed\Process\Dependency\Plugin\Importer\DataImporterPluginInterface $dataImporterPlugin
     */
    public function __construct(protected DataImporterPluginInterface $dataImporterPlugin)
    {
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
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\MethodNotSupportedException !
     *
     * @return int
     */
    public function seek(int $offset, int $whence): int
    {
        throw new MethodNotSupportedException();
    }

    /**
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\MethodNotSupportedException !
     *
     * @return bool
     */
    public function eof(): bool
    {
        throw new MethodNotSupportedException();
    }

    /**
     * @param array<mixed> $data
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
