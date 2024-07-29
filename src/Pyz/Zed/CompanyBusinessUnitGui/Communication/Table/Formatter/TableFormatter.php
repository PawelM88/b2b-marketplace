<?php

declare(strict_types=1);

namespace Pyz\Zed\CompanyBusinessUnitGui\Communication\Table\Formatter;

use Spryker\Zed\Gui\Communication\Table\AbstractTable;

class TableFormatter implements TableFormatterInterface
{
    /**
     * @param \Spryker\Zed\Gui\Communication\Table\AbstractTable $table
     *
     * @return array<string, mixed>
     */
    public function formatAbstractTableToArray(AbstractTable $table): array
    {
        $tableData = $table->fetchData();
        $tableData['header'] = $table->getConfiguration()->getHeader();

        return $tableData;
    }
}
