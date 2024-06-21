<?php

declare(strict_types=1);

namespace Pyz\Zed\CustomerCsvImport\Business\Customer;

use Generated\Shared\Transfer\CustomerListImportRequestTransfer;
use Pyz\Zed\Customer\Communication\File\UploadedFile;
use Spryker\Service\UtilCsv\UtilCsvServiceInterface;
use Spryker\Zed\Store\Business\StoreFacadeInterface;

class CustomerCsvImportReader implements CustomerCsvImportReaderInterface
{
    /**
     * @param \Spryker\Service\UtilCsv\UtilCsvServiceInterface $csvService
     * @param \Pyz\Zed\CustomerCsvImport\Business\Customer\CustomerCsvImportMapperInterface $customerImportMapper
     * @param \Spryker\Zed\Store\Business\StoreFacadeInterface $storeFacade
     */
    public function __construct(
        protected UtilCsvServiceInterface $csvService,
        protected CustomerCsvImportMapperInterface $customerImportMapper,
        protected StoreFacadeInterface $storeFacade,
    ) {
    }

    /**
     * @param \Pyz\Zed\Customer\Communication\File\UploadedFile $uploadedFile
     * @param \Generated\Shared\Transfer\CustomerListImportRequestTransfer $customerListImportRequestTransfer
     *
     * @throws \Spryker\Shared\Kernel\Transfer\Exception\RequiredTransferPropertyException !
     *
     * @return \Generated\Shared\Transfer\CustomerListImportRequestTransfer
     */
    public function readCustomerImportTransfersFromCsvFile(
        UploadedFile $uploadedFile,
        CustomerListImportRequestTransfer $customerListImportRequestTransfer,
    ): CustomerListImportRequestTransfer {
        $importData = $this->csvService->readUploadedFile($uploadedFile);

        $headers = current($importData);
        $importData = $this->removeHeadersFromImportData($importData);

        foreach ($importData as $rowNumber => $rowData) {
            if ($this->isRowDataEmpty($rowData)) {
                continue;
            }
            $combinedImportData = array_combine($headers, $rowData);

            $customerImportTransfer = $this->customerImportMapper->mapCustomerRowToCustomerImportTransfer(
                $combinedImportData,
            );

            $store = $this->storeFacade->findStoreByName($customerImportTransfer->getCompany()->getStoreName());

            if ($store) {
                $customerImportTransfer = $this->customerImportMapper->mapStoreToCompanyTransfer(
                    $customerImportTransfer,
                    $store,
                );
            }

            $customerImportTransfer->requireMetaData();
            $customerImportTransfer->getMetaData()->setIdentifier($rowNumber);

            $customerListImportRequestTransfer->addItem($customerImportTransfer);
        }

        return $customerListImportRequestTransfer;
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
