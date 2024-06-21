<?php

namespace Pyz\Zed\CustomerCsvImport\Business\Customer;

use Generated\Shared\Transfer\CustomerListImportRequestTransfer;
use Pyz\Zed\Customer\Communication\File\UploadedFile;

interface CustomerCsvImportReaderInterface
{
    /**
     * @param \Pyz\Zed\Customer\Communication\File\UploadedFile $uploadedFile
     * @param \Generated\Shared\Transfer\CustomerListImportRequestTransfer $customerListImportRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerListImportRequestTransfer
     */
    public function readCustomerImportTransfersFromCsvFile(
        UploadedFile $uploadedFile,
        CustomerListImportRequestTransfer $customerListImportRequestTransfer,
    ): CustomerListImportRequestTransfer;
}
