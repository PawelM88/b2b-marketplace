<?php

declare(strict_types=1);

namespace Pyz\Zed\CompanyBusinessUnitGui\Communication\Table;

use Generated\Shared\Transfer\CompanyBusinessUnitImportMetaDataTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitListImportErrorTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitListImportResponseTransfer;
use Spryker\Zed\Gui\Communication\Table\AbstractTable;
use Spryker\Zed\Gui\Communication\Table\TableConfiguration;
use Spryker\Zed\Translator\Business\TranslatorFacadeInterface;

class ImportErrorListTable extends AbstractTable
{
    /**
     * @var string
     */
    protected const HEADER_ROW_NUMBER = 'Row n°';

    /**
     * @var string
     */
    protected const HEADER_ERROR = 'Error';

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitListImportResponseTransfer $companyBusinessUnitListImportResponseTransfer
     * @param \Spryker\Zed\Translator\Business\TranslatorFacadeInterface $translatorFacade
     */
    public function __construct(
        protected CompanyBusinessUnitListImportResponseTransfer $companyBusinessUnitListImportResponseTransfer,
        protected TranslatorFacadeInterface $translatorFacade,
    ) {
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return \Spryker\Zed\Gui\Communication\Table\TableConfiguration
     */
    protected function configure(TableConfiguration $config): TableConfiguration
    {
        $config->setHeader([
            CompanyBusinessUnitImportMetaDataTransfer::IDENTIFIER => $this->trans(static::HEADER_ROW_NUMBER),
            CompanyBusinessUnitListImportErrorTransfer::MESSAGE => $this->trans(static::HEADER_ERROR),
        ]);

        $config->setSortable([
            CompanyBusinessUnitImportMetaDataTransfer::IDENTIFIER,
            CompanyBusinessUnitListImportErrorTransfer::MESSAGE,
        ]);

        return $config;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return array<mixed>
     */
    protected function prepareData(TableConfiguration $config): array
    {
        $data = [];

        foreach ($this->companyBusinessUnitListImportResponseTransfer->getErrors() as $companyBusinessUnitListImportErrorTransfer) {
            $data[] = [
                CompanyBusinessUnitImportMetaDataTransfer::IDENTIFIER => $this->formatInt(
                    (int)$companyBusinessUnitListImportErrorTransfer->getCompanyBusinessUnitImport()->getMetaData()->getIdentifier(),
                ),
                CompanyBusinessUnitListImportErrorTransfer::MESSAGE => $this->trans(
                    $companyBusinessUnitListImportErrorTransfer->getMessage(),
                    $companyBusinessUnitListImportErrorTransfer->getParameters(),
                ),
            ];
        }

        return $data;
    }

    /**
     * @param string $id
     * @param array<string, mixed> $params
     *
     * @return string
     */
    protected function trans(string $id, array $params = []): string
    {
        return $this->translatorFacade->trans($id, $params);
    }
}
