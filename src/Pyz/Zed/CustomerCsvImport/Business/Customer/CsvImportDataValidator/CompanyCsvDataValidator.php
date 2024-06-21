<?php

declare(strict_types=1);

namespace Pyz\Zed\CustomerCsvImport\Business\Customer\CsvImportDataValidator;

use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CustomerImportTransfer;
use Generated\Shared\Transfer\CustomerListImportErrorTransfer;
use Pyz\Zed\Customer\CustomerConfig;

class CompanyCsvDataValidator extends AbstractCsvImportDataValidator
{
    /**
     * @var string
     */
    public const ERROR_MESSAGE_REQUIRED_COMPANY_FIELDS = 'One or more of required fields: brand_id, brand_name, brand_market, brand_active or brand_status is missed.';

    /**
     * @var string
     */
    protected const ERROR_MESSAGE_COUNTRY_NOT_VALID = 'Provided country in brand_market is invalid.';

    /**
     * @var string
     */
    protected const ERROR_MESSAGE_COMPANY_KEY_STRING_255 = 'Provided: %s in brand_id is invalid. It must be a string and not longer than 255 characters.';

    /**
     * @var string
     */
    protected const ERROR_MESSAGE_COMPANY_NAME_STRING_255 = 'Provided: %s in brand_name is invalid. It must be a string and not longer than 255 characters.';

    /**
     * @var string
     */
    protected const ERROR_MESSAGE_IS_ACTIVE_NOT_PREDEFINED = 'Provided: %s in brand_active is invalid. It must be a boolean type: true or false';

    /**
     * @var string
     */
    protected const ERROR_MESSAGE_STATUS_NOT_PREDEFINED = 'Provided: %s in brand_status is invalid. The only values that can be: approved, pending or denied';

    /**
     * @param \Generated\Shared\Transfer\CustomerImportTransfer $customerImportTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerListImportErrorTransfer|null
     */
    public function validateCustomerImportTransfer(CustomerImportTransfer $customerImportTransfer): ?CustomerListImportErrorTransfer
    {
        $companyTransfer = $customerImportTransfer->getCompany();

        if ($this->requiredCompanyFieldsProvided($companyTransfer) === false) {
            $errorMessage = static::ERROR_MESSAGE_REQUIRED_COMPANY_FIELDS;

            return $this->createCustomerCsvImportDataErrorTransfer(
                $customerImportTransfer,
                $errorMessage,
            );
        }

        if ($companyTransfer->getStoreRelation() === null) {
            $errorMessage = static::ERROR_MESSAGE_COUNTRY_NOT_VALID;

            return $this->createCustomerCsvImportDataErrorTransfer(
                $customerImportTransfer,
                $errorMessage,
            );
        }

        if ($this->isStringValid255($companyTransfer->getKey()) === false) {
            $errorMessage = sprintf(
                static::ERROR_MESSAGE_COMPANY_KEY_STRING_255,
                $companyTransfer->getKey(),
            );

            return $this->createCustomerCsvImportDataErrorTransfer(
                $customerImportTransfer,
                $errorMessage,
            );
        }

        if ($this->isStringValid255($companyTransfer->getName()) === false) {
            $errorMessage = sprintf(
                static::ERROR_MESSAGE_COMPANY_NAME_STRING_255,
                $companyTransfer->getName(),
            );

            return $this->createCustomerCsvImportDataErrorTransfer(
                $customerImportTransfer,
                $errorMessage,
            );
        }

        if ($this->isActivePredefined($companyTransfer) === false) {
            $errorMessage = sprintf(
                static::ERROR_MESSAGE_IS_ACTIVE_NOT_PREDEFINED,
                $companyTransfer->getIsActive(),
            );

            return $this->createCustomerCsvImportDataErrorTransfer(
                $customerImportTransfer,
                $errorMessage,
            );
        }

        if ($this->isStatusPredefined($companyTransfer) === false) {
            $errorMessage = sprintf(
                static::ERROR_MESSAGE_STATUS_NOT_PREDEFINED,
                $companyTransfer->getStatus(),
            );

            return $this->createCustomerCsvImportDataErrorTransfer(
                $customerImportTransfer,
                $errorMessage,
            );
        }

        return null;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return bool
     */
    protected function requiredCompanyFieldsProvided(CompanyTransfer $companyTransfer): bool
    {
        $fieldsToCheck = [
            'Key' => $companyTransfer->getKey(),
            'Name' => $companyTransfer->getName(),
            'Active' => $companyTransfer->getIsActive(),
            'Status' => $companyTransfer->getStatus(),
            'StoreName' => $companyTransfer->getStoreName(),
        ];

        foreach ($fieldsToCheck as $field) {
            if (!$field) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return bool
     */
    protected function isActivePredefined(CompanyTransfer $companyTransfer): bool
    {
        if ($companyTransfer->getIsActive() == 'true' || $companyTransfer->getIsActive() == 'false') {
            return true;
        }

        return false;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return bool
     */
    protected function isStatusPredefined(CompanyTransfer $companyTransfer): bool
    {
        if (
            $companyTransfer->getStatus() === CustomerConfig::STATUS_APPROVED ||
            $companyTransfer->getStatus() === CustomerConfig::STATUS_PENDING ||
            $companyTransfer->getStatus() === CustomerConfig::STATUS_DENIED
        ) {
            return true;
        }

        return false;
    }
}
