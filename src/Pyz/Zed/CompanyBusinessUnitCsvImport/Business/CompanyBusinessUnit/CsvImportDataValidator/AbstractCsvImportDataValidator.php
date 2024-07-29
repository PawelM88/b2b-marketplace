<?php

declare(strict_types=1);

namespace Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CsvImportDataValidator;

use Generated\Shared\Transfer\CompanyBusinessUnitImportTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitListImportErrorTransfer;

abstract class AbstractCsvImportDataValidator implements CompanyBusinessUnitCsvImportDataValidatorInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitImportTransfer $companyBusinessUnitImportTransfer
     * @param string $errorMessage
     * @param array<string, mixed> $parameters
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitListImportErrorTransfer
     */
    protected function createCompanyBusinessUnitCsvImportDataErrorTransfer(
        CompanyBusinessUnitImportTransfer $companyBusinessUnitImportTransfer,
        string $errorMessage,
        array $parameters = [],
    ): CompanyBusinessUnitListImportErrorTransfer {
        return (new CompanyBusinessUnitListImportErrorTransfer())
            ->setCompanyBusinessUnitImport($companyBusinessUnitImportTransfer)
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
