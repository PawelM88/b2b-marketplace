<?php

declare(strict_types=1);

namespace Pyz\Zed\CustomerCsvImport\Business\Customer;

use Generated\Shared\Transfer\CustomerImportTransfer;
use Generated\Shared\Transfer\CustomerListImportErrorTransfer;

class CustomerImportDataValidator implements CustomerImportDataValidatorInterface
{
 /**
  * @param array<\Pyz\Zed\CustomerCsvImport\Business\Customer\CsvImportDataValidator\CustomerCsvImportDataValidatorInterface> $dataValidatorList
  */
    public function __construct(protected array $dataValidatorList = [])
    {
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerImportTransfer $customerImportTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerListImportErrorTransfer|null
     */
    public function validateCustomerImportTransfer(CustomerImportTransfer $customerImportTransfer): ?CustomerListImportErrorTransfer
    {
        foreach ($this->dataValidatorList as $dataValidator) {
            $customerImportError = $dataValidator->validateCustomerImportTransfer($customerImportTransfer);

            if ($customerImportError !== null) {
                return $customerImportError;
            }
        }

        return null;
    }
}
