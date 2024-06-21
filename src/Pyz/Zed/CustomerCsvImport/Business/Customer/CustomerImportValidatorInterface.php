<?php

namespace Pyz\Zed\CustomerCsvImport\Business\Customer;

use Generated\Shared\Transfer\CustomerListImportRequestTransfer;
use Generated\Shared\Transfer\CustomerListImportResponseTransfer;

interface CustomerImportValidatorInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerListImportRequestTransfer $customerListImportRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerListImportResponseTransfer
     */
    public function validateCustomerCsvData(CustomerListImportRequestTransfer $customerListImportRequestTransfer): CustomerListImportResponseTransfer;
}
