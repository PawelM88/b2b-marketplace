<?php

declare(strict_types=1);

namespace Pyz\Zed\CompanyBusinessUnitGui;

use Spryker\Zed\CompanyBusinessUnitGui\CompanyBusinessUnitGuiConfig as SprykerCompanyBusinessUnitGuiConfig;

class CompanyBusinessUnitGuiConfig extends SprykerCompanyBusinessUnitGuiConfig
{
    /**
     * @return array<string>
     */
    public function getFileMimeTypes(): array
    {
        return ['text/csv'];
    }

    /**
     * @return string
     */
    public function getMaxFileSize(): string
    {
        return '50M';
    }
}
