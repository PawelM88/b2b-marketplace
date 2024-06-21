<?php

declare(strict_types=1);

namespace Pyz\Zed\CustomerCsvImport\Business\Customer\CsvImportDataValidator;

use Generated\Shared\Transfer\CustomerImportTransfer;
use Generated\Shared\Transfer\CustomerListImportErrorTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Pyz\Zed\Customer\CustomerConfig;

class CustomerCsvDataValidator extends AbstractCsvImportDataValidator
{
    /**
     * @var string
     */
    public const ERROR_MESSAGE_REQUIRED_CUSTOMER_FIELDS = 'One or more of required fields: admin_salutation, admin_first_name, admin_last_name, admin_email or admin_gender is missed.';

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
     * @var string
     */
    protected const ERROR_MESSAGE_CUSTOMER_GENDER_NOT_PREDEFINED = 'Provided: %s in admin_gender is invalid. It must be the same as predefined genders.';

    /**
     * @param \Generated\Shared\Transfer\CustomerImportTransfer $customerImportTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerListImportErrorTransfer|null
     */
    public function validateCustomerImportTransfer(CustomerImportTransfer $customerImportTransfer): ?CustomerListImportErrorTransfer
    {
        $customerTransfer = $customerImportTransfer->getCustomer();

        if ($this->requiredCustomerFieldsProvided($customerTransfer) === false) {
            $errorMessage = static::ERROR_MESSAGE_REQUIRED_CUSTOMER_FIELDS;

            return $this->createCustomerCsvImportDataErrorTransfer(
                $customerImportTransfer,
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

            return $this->createCustomerCsvImportDataErrorTransfer(
                $customerImportTransfer,
                $errorMessage,
            );
        }

        if ($this->isEmailValid255($customerTransfer->getEmail()) === false) {
            $errorMessage = sprintf(
                static::ERROR_MESSAGE_CUSTOMER_EMAIL_STRING_255,
                $customerTransfer->getEmail(),
            );

            return $this->createCustomerCsvImportDataErrorTransfer(
                $customerImportTransfer,
                $errorMessage,
            );
        }

        if ($this->isStringValid100($customerTransfer->getFirstName()) === false) {
            $errorMessage = sprintf(
                static::ERROR_MESSAGE_CUSTOMER_FIRST_NAME_STRING_100,
                $customerTransfer->getFirstName(),
            );

            return $this->createCustomerCsvImportDataErrorTransfer(
                $customerImportTransfer,
                $errorMessage,
            );
        }

        if ($this->isStringValid100($customerTransfer->getLastName()) === false) {
            $errorMessage = sprintf(
                static::ERROR_MESSAGE_CUSTOMER_LAST_NAME_STRING_100,
                $customerTransfer->getLastName(),
            );

            return $this->createCustomerCsvImportDataErrorTransfer(
                $customerImportTransfer,
                $errorMessage,
            );
        }

        if ($this->isGenderPredefined($customerTransfer->getGender()) === false) {
            $errorMessage = sprintf(
                static::ERROR_MESSAGE_CUSTOMER_GENDER_NOT_PREDEFINED,
                $customerTransfer->getGender(),
            );

            return $this->createCustomerCsvImportDataErrorTransfer(
                $customerImportTransfer,
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
            'Gender' => $customerTransfer->getGender(),
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
            $customerSalutation === CustomerConfig::PREDEFINED_SALUTATION_MR ||
            $customerSalutation === CustomerConfig::PREDEFINED_SALUTATION_MS ||
            $customerSalutation === CustomerConfig::PREDEFINED_SALUTATION_MRS ||
            $customerSalutation === CustomerConfig::PREDEFINED_SALUTATION_DR
        ) {
            return true;
        }

        return false;
    }

    /**
     * @param string $customerGender
     *
     * @return bool
     */
    protected function isGenderPredefined(string $customerGender): bool
    {
        if (
            $customerGender === CustomerConfig::PREDEFINED_GENDER_MALE ||
            $customerGender === CustomerConfig::PREDEFINED_GENDER_FEMALE
        ) {
            return true;
        }

        return false;
    }
}
