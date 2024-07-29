<?php

declare(strict_types=1);

namespace Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit;

use Generated\Shared\Transfer\CompanyBusinessUnitListImportRequestTransfer;
use Pyz\Zed\CompanyBusinessUnitGui\Communication\File\UploadedFile;
use Spryker\Service\UtilCsv\UtilCsvServiceInterface;
use Spryker\Zed\Store\Business\StoreFacadeInterface;

class CompanyBusinessUnitCsvImportReader implements CompanyBusinessUnitCsvImportReaderInterface
{
    /**
     * @param \Spryker\Service\UtilCsv\UtilCsvServiceInterface $csvService
     * @param \Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CompanyBusinessUnitCsvImportMapperInterface $companyBusinessUnitImportMapper
     * @param \Spryker\Zed\Store\Business\StoreFacadeInterface $storeFacade
     */
    public function __construct(
        protected UtilCsvServiceInterface $csvService,
        protected CompanyBusinessUnitCsvImportMapperInterface $companyBusinessUnitImportMapper,
        protected StoreFacadeInterface $storeFacade,
    ) {
    }

    /**
     * @param \Pyz\Zed\CompanyBusinessUnitGui\Communication\File\UploadedFile $uploadedFile
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitListImportRequestTransfer $companyBusinessUnitListImportRequestTransfer
     *
     * @throws \Spryker\Shared\Kernel\Transfer\Exception\RequiredTransferPropertyException !
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitListImportRequestTransfer
     */
    public function readCompanyBusinessUnitImportTransfersFromCsvFile(
        UploadedFile $uploadedFile,
        CompanyBusinessUnitListImportRequestTransfer $companyBusinessUnitListImportRequestTransfer,
    ): CompanyBusinessUnitListImportRequestTransfer {
        $importData = $this->csvService->readUploadedFile($uploadedFile);

        $headers = current($importData);
        $importData = $this->removeHeadersFromImportData($importData);

        foreach ($importData as $rowNumber => $rowData) {
            if ($this->isRowDataEmpty($rowData)) {
                continue;
            }
            $combinedImportData = array_combine($headers, $rowData);

            $companyBusinessUnitImportTransfer = $this->companyBusinessUnitImportMapper->mapCompanyBusinessUnitRowToCompanyBusinessUnitImportTransfer(
                $combinedImportData,
            );

            $store = $this->storeFacade->findStoreByName($companyBusinessUnitImportTransfer->getCompany()->getStoreName());

            if ($store) {
                $companyBusinessUnitImportTransfer = $this->companyBusinessUnitImportMapper->mapStoreToCompanyTransfer(
                    $companyBusinessUnitImportTransfer,
                    $store,
                );
            }

            $companyBusinessUnitImportTransfer->requireMetaData();
            $companyBusinessUnitImportTransfer->getMetaData()->setIdentifier($rowNumber);

            $companyBusinessUnitListImportRequestTransfer->addItem($companyBusinessUnitImportTransfer);
        }

        return $companyBusinessUnitListImportRequestTransfer;
    }

    /**
     * @param array<mixed> $importData
     *
     * @return array<mixed>
     */
    protected function removeHeadersFromImportData(array $importData): array
    {
        unset($importData[0]);

        return $importData;
    }

    /**
     * @param array<string, mixed> $rowData
     *
     * @return bool
     */
    protected function isRowDataEmpty(array $rowData): bool
    {
        $clearedRowData = $this->clearRowDataFromEmptyValues($rowData);

        return !$clearedRowData;
    }

    /**
     * @param array<string, mixed> $rowData
     *
     * @return array<string, mixed>
     */
    protected function clearRowDataFromEmptyValues(array $rowData): array
    {
        return array_filter($rowData);
    }
}
