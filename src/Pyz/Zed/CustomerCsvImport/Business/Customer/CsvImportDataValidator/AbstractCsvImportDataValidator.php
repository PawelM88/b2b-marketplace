<?php

declare(strict_types=1);

namespace Pyz\Zed\CustomerCsvImport\Business\Customer\CsvImportDataValidator;

use Generated\Shared\Transfer\CustomerImportTransfer;
use Generated\Shared\Transfer\CustomerListImportErrorTransfer;

abstract class AbstractCsvImportDataValidator implements CustomerCsvImportDataValidatorInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerImportTransfer $customerImportTransfer
     * @param string $errorMessage
     * @param array<string, mixed> $parameters
     *
     * @return \Generated\Shared\Transfer\CustomerListImportErrorTransfer
     */
    protected function createCustomerCsvImportDataErrorTransfer(
        CustomerImportTransfer $customerImportTransfer,
        string $errorMessage,
        array $parameters = [],
    ): CustomerListImportErrorTransfer {
        return (new CustomerListImportErrorTransfer())
            ->setCustomerImport($customerImportTransfer)
            ->setMessage($errorMessage)
            ->setParameters($parameters);
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    protected function isStringValid255(mixed $value): bool
    {
        if (!is_string($value) || strlen($value) > 255) {
            return false;
        }

        return true;
    }

    /**
     * @param mixed $value
     *
     * @return bool
     */
    protected function isStringValid100(mixed $value): bool
    {
        if (!is_string($value) || strlen($value) > 100) {
            return false;
        }

        return true;
    }

    /**
     * @param string $email
     *
     * @return bool
     */
    protected function isEmailValid255(string $email): bool
    {
        if (!strpos($email, '@') || strlen($email) > 255) {
            return false;
        }

        return true;
    }
}
