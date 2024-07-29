<?php

namespace Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit;

use Generated\Shared\Transfer\CompanyBusinessUnitCsvValidationResultTransfer;
use Pyz\Zed\CompanyBusinessUnitGui\Communication\File\UploadedFile;

interface CompanyBusinessUnitCsvImportHeadersValidatorInterface
{
    /**
     * @param \Pyz\Zed\CompanyBusinessUnitGui\Communication\File\UploadedFile $uploadedFile
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitCsvValidationResultTransfer
     */
    public function validateCsvFile(UploadedFile $uploadedFile): CompanyBusinessUnitCsvValidationResultTransfer;
}
