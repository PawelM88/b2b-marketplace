<?php

namespace Pyz\Zed\CustomerCsvImport\Business\Customer;

use Generated\Shared\Transfer\CustomerImportTransfer;
use Generated\Shared\Transfer\CustomerListImportErrorTransfer;

interface CustomerImportDataValidatorInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerImportTransfer $customerImportTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerListImportErrorTransfer|null
     */
    public function validateCustomerImportTransfer(CustomerImportTransfer $customerImportTransfer): ?CustomerListImportErrorTransfer;
}
