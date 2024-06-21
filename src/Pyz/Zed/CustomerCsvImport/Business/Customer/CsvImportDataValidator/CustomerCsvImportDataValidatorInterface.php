<?php

namespace Pyz\Zed\CustomerCsvImport\Business\Customer\CsvImportDataValidator;

use Generated\Shared\Transfer\CustomerImportTransfer;
use Generated\Shared\Transfer\CustomerListImportErrorTransfer;

interface CustomerCsvImportDataValidatorInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerImportTransfer $customerImportTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerListImportErrorTransfer|null
     */
    public function validateCustomerImportTransfer(CustomerImportTransfer $customerImportTransfer): ?CustomerListImportErrorTransfer;
}
