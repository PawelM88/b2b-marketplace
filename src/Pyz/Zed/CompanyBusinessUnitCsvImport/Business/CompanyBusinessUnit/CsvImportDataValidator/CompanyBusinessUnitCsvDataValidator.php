<?php

declare(strict_types=1);

namespace Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CsvImportDataValidator;

use Generated\Shared\Transfer\CompanyBusinessUnitImportTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitListImportErrorTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;

class CompanyBusinessUnitCsvDataValidator extends AbstractCsvImportDataValidator
{
    /**
     * @var string
     */
    public const ERROR_MESSAGE_REQUIRED_COMPANY_BUSINESS_UNIT_FIELDS = 'Not all required fields have been filled in. If the business unit is Headquarters, only the fields: sold_to_id and sold_to_name can be filled. If the business unit is the parent of another business unit, fill in the following fields: sold_to_id, sold_to_name, ship_to_id and ship_to_name.';

    /**
     * @var string
     */
    protected const ERROR_MESSAGE_COMPANY_BUSINESS_UNIT_KEY_STRING_255 = 'Provided: %s in sold_to_id or ship_to_id is invalid. It must be a string and not longer than 255 characters.';

    /**
     * @var string
     */
    protected const ERROR_MESSAGE_COMPANY_BUSINESS_UNIT_NAME_STRING_255 = 'Provided: %s in sold_to_name or ship_to_name is invalid. It must be a string and not longer than 255 characters.';

    /**
     * @var string
     */
    protected const ERROR_MESSAGE_COMPANY_BUSINESS_UNIT_EMAIL_STRING_255 = 'Provided: %s in email is invalid. It must be a proper email address and not longer than 255 characters.';

    /**
     * @var string
     */
    protected const ERROR_MESSAGE_PARENT_COMPANY_BUSINESS_UNIT_KEY_STRING_255 = 'Provided: %s in sold_to_id is invalid. It must be a string and not longer than 255 characters.';

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitImportTransfer $companyBusinessUnitImportTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitListImportErrorTransfer|null
     */
    public function validateCompanyBusinessUnitImportTransfer(
        CompanyBusinessUnitImportTransfer $companyBusinessUnitImportTransfer,
    ): ?CompanyBusinessUnitListImportErrorTransfer {
        $companyBusinessUnitTransfer = $companyBusinessUnitImportTransfer->getCompanyBusinessUnit();

        if ($this->requiredCompanyBusinessUnitFieldsProvided($companyBusinessUnitTransfer) === true) {
            $errorMessage = static::ERROR_MESSAGE_REQUIRED_COMPANY_BUSINESS_UNIT_FIELDS;

            return $this->createCompanyBusinessUnitCsvImportDataErrorTransfer(
                $companyBusinessUnitImportTransfer,
                $errorMessage,
            );
        }

        if ($this->isStringValid255($companyBusinessUnitTransfer->getKey()) === false) {
            $errorMessage = sprintf(
                static::ERROR_MESSAGE_COMPANY_BUSINESS_UNIT_KEY_STRING_255,
                $companyBusinessUnitTransfer->getKey(),
            );

            return $this->createCompanyBusinessUnitCsvImportDataErrorTransfer(
                $companyBusinessUnitImportTransfer,
                $errorMessage,
            );
        }

        if ($this->isStringValid255($companyBusinessUnitTransfer->getName()) === false) {
            $errorMessage = sprintf(
                static::ERROR_MESSAGE_COMPANY_BUSINESS_UNIT_NAME_STRING_255,
                $companyBusinessUnitTransfer->getName(),
            );

            return $this->createCompanyBusinessUnitCsvImportDataErrorTransfer(
                $companyBusinessUnitImportTransfer,
                $errorMessage,
            );
        }

        if ($this->isEmailValid255($companyBusinessUnitTransfer->getEmail()) === false) {
            $errorMessage = sprintf(
                static::ERROR_MESSAGE_COMPANY_BUSINESS_UNIT_EMAIL_STRING_255,
                $companyBusinessUnitTransfer->getEmail(),
            );

            return $this->createCompanyBusinessUnitCsvImportDataErrorTransfer(
                $companyBusinessUnitImportTransfer,
                $errorMessage,
            );
        }

        if ($companyBusinessUnitTransfer->getFkParentCompanyBusinessUnit()) {
            if ($this->isStringValid255($companyBusinessUnitTransfer->getParentCompanyBusinessUnitKey()) === false) {
                $errorMessage = sprintf(
                    static::ERROR_MESSAGE_PARENT_COMPANY_BUSINESS_UNIT_KEY_STRING_255,
                    $companyBusinessUnitTransfer->getParentCompanyBusinessUnitKey(),
                );

                return $this->createCompanyBusinessUnitCsvImportDataErrorTransfer(
                    $companyBusinessUnitImportTransfer,
                    $errorMessage,
                );
            }
        }

        return null;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
     *
     * @return bool
     */
    protected function requiredCompanyBusinessUnitFieldsProvided(
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer,
    ): bool {
        return empty($companyBusinessUnitTransfer->getKey()) || empty($companyBusinessUnitTransfer->getName());
    }
}
