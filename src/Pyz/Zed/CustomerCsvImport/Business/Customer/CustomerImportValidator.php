<?php

declare(strict_types=1);

namespace Pyz\Zed\CustomerCsvImport\Business\Customer;

use Generated\Shared\Transfer\CustomerListImportRequestTransfer;
use Generated\Shared\Transfer\CustomerListImportResponseTransfer;

class CustomerImportValidator implements CustomerImportValidatorInterface
{
    /**
     * @param \Pyz\Zed\CustomerCsvImport\Business\Customer\CustomerImportDataValidatorInterface $customerImportDataValidator
     */
    public function __construct(protected CustomerImportDataValidatorInterface $customerImportDataValidator)
    {
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerListImportRequestTransfer $customerListImportRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerListImportResponseTransfer
     */
    public function validateCustomerCsvData(CustomerListImportRequestTransfer $customerListImportRequestTransfer): CustomerListImportResponseTransfer
    {
        $customerListImportResponseTransfer = new CustomerListImportResponseTransfer();

        foreach ($customerListImportRequestTransfer->getItems() as $customerImportTransfer) {
            $customerListImportError = $this->customerImportDataValidator->validateCustomerImportTransfer(
                $customerImportTransfer,
            );

            if ($customerListImportError !== null) {
                $customerListImportResponseTransfer->addError($customerListImportError);

                continue;
            }

            $customerListImportResponseTransfer->setIsSuccess(true);
        }

        $customerListImportResponseTransfer->setCustomerListImportRequest($customerListImportRequestTransfer);

        return $customerListImportResponseTransfer;
    }
}
