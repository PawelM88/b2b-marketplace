<?php

declare(strict_types=1);

namespace Pyz\Zed\CompanyBusinessUnitGui\Communication\File;

use Symfony\Component\HttpFoundation\File\UploadedFile as SymfonyUploadedFile;

class UploadedFile extends SymfonyUploadedFile
{
    /**
     * The method checks if `UploadedFile::size` property exists to support BC for the `Symfony\HttpFoundation` of version lower than v4.1.0.
     *
     * @param string $path
     * @param string $originalName
     * @param string|null $mimeType
     * @param int|null $size
     * @param int|null $error
     * @param bool $test
     */
    public function __construct(
        string $path,
        string $originalName,
        ?string $mimeType = null,
        ?int $size = null,
        ?int $error = null,
        bool $test = false,
    ) {
        if (property_exists($this, 'size')) {
            parent::__construct($path, $originalName, $mimeType, $size);

            return;
        }

        parent::__construct($path, $originalName, $mimeType, $error, $test);
    }
}
