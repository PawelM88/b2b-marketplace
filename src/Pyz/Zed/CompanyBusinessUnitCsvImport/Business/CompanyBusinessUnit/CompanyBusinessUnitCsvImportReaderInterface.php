<?php

namespace Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit;

use Generated\Shared\Transfer\CompanyBusinessUnitListImportRequestTransfer;
use Pyz\Zed\CompanyBusinessUnitGui\Communication\File\UploadedFile;

interface CompanyBusinessUnitCsvImportReaderInterface
{
    /**
     * @param \Pyz\Zed\CompanyBusinessUnitGui\Communication\File\UploadedFile $uploadedFile
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitListImportRequestTransfer $companyBusinessUnitListImportRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitListImportRequestTransfer
     */
    public function readCompanyBusinessUnitImportTransfersFromCsvFile(
        UploadedFile $uploadedFile,
        CompanyBusinessUnitListImportRequestTransfer $companyBusinessUnitListImportRequestTransfer,
    ): CompanyBusinessUnitListImportRequestTransfer;
}
