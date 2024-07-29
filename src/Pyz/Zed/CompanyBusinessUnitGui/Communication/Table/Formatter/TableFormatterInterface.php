<?php

namespace Pyz\Zed\CompanyBusinessUnitGui\Communication\Table\Formatter;

use Spryker\Zed\Gui\Communication\Table\AbstractTable;

interface TableFormatterInterface
{
    /**
     * @param \Spryker\Zed\Gui\Communication\Table\AbstractTable $table
     *
     * @return array<string, mixed>
     */
    public function formatAbstractTableToArray(AbstractTable $table): array;
}
