<?php

declare(strict_types=1);

namespace Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CsvImportDataValidator;

use Generated\Shared\Transfer\CompanyBusinessUnitImportTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitListImportErrorTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Pyz\Zed\CompanyBusinessUnitCsvImport\CompanyBusinessUnitCsvImportConfig;

class CustomerCsvDataValidator extends AbstractCsvImportDataValidator
{
    /**
     * @var string
     */
    public const ERROR_MESSAGE_REQUIRED_CUSTOMER_FIELDS = 'One or more of required fields: admin_salutation, admin_first_name, admin_last_name or admin_email is missed.';

    /**
     * @var string
     */
    protected const ERROR_MESSAGE_CUSTOMER_SALUTATION_NOT_PREDEFINED = 'Provided: %s in salutation is invalid. It must be the same as predefined salutations.';

    /**
     * @var string
     */
    protected const ERROR_MESSAGE_CUSTOMER_EMAIL_STRING_255 = 'Provided: %s in admin_email is invalid. It must be a proper email address and not longer than 255 characters.';

    /**
     * @var string
     */
    protected const ERROR_MESSAGE_CUSTOMER_FIRST_NAME_STRING_100 = 'Provided: %s in admin_first_name is invalid. It must be a string and not longer than 100 characters.';

    /**
     * @var string
     */
    protected const ERROR_MESSAGE_CUSTOMER_LAST_NAME_STRING_100 = 'Provided: %s in admin_last_name is invalid. It must be a string and not longer than 100 characters.';

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitImportTransfer $companyBusinessUnitImportTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitListImportErrorTransfer|null
     */
    public function validateCompanyBusinessUnitImportTransfer(
        CompanyBusinessUnitImportTransfer $companyBusinessUnitImportTransfer,
    ): ?CompanyBusinessUnitListImportErrorTransfer {
        $customerTransfer = $companyBusinessUnitImportTransfer->getCustomer();

        if ($this->requiredCustomerFieldsProvided($customerTransfer) === false) {
            $errorMessage = static::ERROR_MESSAGE_REQUIRED_CUSTOMER_FIELDS;

            return $this->createCompanyBusinessUnitCsvImportDataErrorTransfer(
                $companyBusinessUnitImportTransfer,
                $errorMessage,
            );
        }

        if (
            $this->
            isSalutationPredefined($customerTransfer->getSalutation()) === false
        ) {
            $errorMessage = sprintf(
                static::ERROR_MESSAGE_CUSTOMER_SALUTATION_NOT_PREDEFINED,
                $customerTransfer->getSalutation(),
            );

            return $this->createCompanyBusinessUnitCsvImportDataErrorTransfer(
                $companyBusinessUnitImportTransfer,
                $errorMessage,
            );
        }

        if ($this->isEmailValid255($customerTransfer->getEmail()) === false) {
            $errorMessage = sprintf(
                static::ERROR_MESSAGE_CUSTOMER_EMAIL_STRING_255,
                $customerTransfer->getEmail(),
            );

            return $this->createCompanyBusinessUnitCsvImportDataErrorTransfer(
                $companyBusinessUnitImportTransfer,
                $errorMessage,
            );
        }

        if ($this->isStringValid100($customerTransfer->getFirstName()) === false) {
            $errorMessage = sprintf(
                static::ERROR_MESSAGE_CUSTOMER_FIRST_NAME_STRING_100,
                $customerTransfer->getFirstName(),
            );

            return $this->createCompanyBusinessUnitCsvImportDataErrorTransfer(
                $companyBusinessUnitImportTransfer,
                $errorMessage,
            );
        }

        if ($this->isStringValid100($customerTransfer->getLastName()) === false) {
            $errorMessage = sprintf(
                static::ERROR_MESSAGE_CUSTOMER_LAST_NAME_STRING_100,
                $customerTransfer->getLastName(),
            );

            return $this->createCompanyBusinessUnitCsvImportDataErrorTransfer(
                $companyBusinessUnitImportTransfer,
                $errorMessage,
            );
        }

        return null;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return bool
     */
    protected function requiredCustomerFieldsProvided(CustomerTransfer $customerTransfer): bool
    {
        $fieldsToCheck = [
            'Salutation' => $customerTransfer->getSalutation(),
            'FirstName' => $customerTransfer->getFirstName(),
            'LastName' => $customerTransfer->getLastName(),
            'Email' => $customerTransfer->getEmail(),
        ];

        foreach ($fieldsToCheck as $field) {
            if (!$field) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param string $customerSalutation
     *
     * @return bool
     */
    protected function isSalutationPredefined(string $customerSalutation): bool
    {
        if (
            $customerSalutation === CompanyBusinessUnitCsvImportConfig::PREDEFINED_SALUTATION_MR ||
            $customerSalutation === CompanyBusinessUnitCsvImportConfig::PREDEFINED_SALUTATION_MS ||
            $customerSalutation === CompanyBusinessUnitCsvImportConfig::PREDEFINED_SALUTATION_MRS ||
            $customerSalutation === CompanyBusinessUnitCsvImportConfig::PREDEFINED_SALUTATION_DR
        ) {
            return true;
        }

        return false;
    }
}
