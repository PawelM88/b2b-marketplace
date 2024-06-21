<?php

declare(strict_types=1);

namespace Pyz\Zed\Customer\Communication\Table;

use Generated\Shared\Transfer\CustomerImportMetaDataTransfer;
use Generated\Shared\Transfer\CustomerListImportErrorTransfer;
use Generated\Shared\Transfer\CustomerListImportResponseTransfer;
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
     * @param \Generated\Shared\Transfer\CustomerListImportResponseTransfer $customerListImportResponseTransfer
     * @param \Spryker\Zed\Translator\Business\TranslatorFacadeInterface $translatorFacade
     */
    public function __construct(
        protected CustomerListImportResponseTransfer $customerListImportResponseTransfer,
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
            CustomerImportMetaDataTransfer::IDENTIFIER => $this->trans(static::HEADER_ROW_NUMBER),
            CustomerListImportErrorTransfer::MESSAGE => $this->trans(static::HEADER_ERROR),
        ]);

        $config->setSortable([
            CustomerImportMetaDataTransfer::IDENTIFIER,
            CustomerListImportErrorTransfer::MESSAGE,
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

        foreach ($this->customerListImportResponseTransfer->getErrors() as $customerListImportErrorTransfer) {
            $data[] = [
                CustomerImportMetaDataTransfer::IDENTIFIER => $this->formatInt(
                    (int)$customerListImportErrorTransfer->getCustomerImport()->getMetaData()->getIdentifier(),
                ),
                CustomerListImportErrorTransfer::MESSAGE => $this->trans(
                    $customerListImportErrorTransfer->getMessage(),
                    $customerListImportErrorTransfer->getParameters(),
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
