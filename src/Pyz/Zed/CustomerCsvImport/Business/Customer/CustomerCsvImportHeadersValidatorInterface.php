<?php

namespace Pyz\Zed\CustomerCsvImport\Business\Customer;

use Generated\Shared\Transfer\CustomerCsvValidationResultTransfer;
use Pyz\Zed\Customer\Communication\File\UploadedFile;

interface CustomerCsvImportHeadersValidatorInterface
{
    /**
     * @param \Pyz\Zed\Customer\Communication\File\UploadedFile $uploadedFile
     *
     * @return \Generated\Shared\Transfer\CustomerCsvValidationResultTransfer
     */
    public function validateCsvFile(UploadedFile $uploadedFile): CustomerCsvValidationResultTransfer;
}
