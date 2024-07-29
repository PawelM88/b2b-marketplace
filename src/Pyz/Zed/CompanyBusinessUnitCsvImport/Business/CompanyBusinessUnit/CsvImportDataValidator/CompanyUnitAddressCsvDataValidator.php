<?php

declare(strict_types=1);

namespace Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CsvImportDataValidator;

use Generated\Shared\Transfer\CompanyBusinessUnitImportTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitListImportErrorTransfer;
use Generated\Shared\Transfer\CompanyUnitAddressTransfer;
use Spryker\Zed\Country\Business\CountryFacadeInterface;

class CompanyUnitAddressCsvDataValidator extends AbstractCsvImportDataValidator
{
    /**
     * @var string
     */
    public const ERROR_MESSAGE_REQUIRED_COMPANY_UNIT_ADDRESS_FIELDS = 'One or more of required fields: address_id or country_iso2_code is missed.';

    /**
     * @var string
     */
    protected const ERROR_MESSAGE_COMPANY_UNIT_ADDRESS_ADDRESS_STRING_255 = 'Provided: %s in address1, address2 or address3 is invalid. It must be a string and not longer than 255 characters.';

    /**
     * @var string
     */
    protected const ERROR_MESSAGE_COMPANY_UNIT_ADDRESS_STATE_STRING_255 = 'Provided: %s in state is invalid. It must be a string and not longer than 255 characters.';

    /**
     * @var string
     */
    protected const ERROR_MESSAGE_COMPANY_UNIT_ADDRESS_CITY_STRING_255 = 'Provided: %s in city is invalid. It must be a string and not longer than 255 characters.';

    /**
     * @var string
     */
    protected const ERROR_MESSAGE_COMPANY_UNIT_ADDRESS_ZIP_CODE_NUMERIC_15 = 'Provided: %s in zip_code is invalid. It must be a string and not longer than 15 characters.';

    /**
     * @var string
     */
    protected const ERROR_MESSAGE_COMPANY_UNIT_ADDRESS_ISO2_CODE_NOT_VALID = 'Provided: %s in country_iso2_code is invalid.';

    /**
     * @param \Spryker\Zed\Country\Business\CountryFacadeInterface $countryFacade
     */
    public function __construct(protected CountryFacadeInterface $countryFacade)
    {
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitImportTransfer $companyBusinessUnitImportTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitListImportErrorTransfer|null
     */
    public function validateCompanyBusinessUnitImportTransfer(
        CompanyBusinessUnitImportTransfer $companyBusinessUnitImportTransfer,
    ): ?CompanyBusinessUnitListImportErrorTransfer {
        $companyUnitAddressTransfer = $companyBusinessUnitImportTransfer->getCompanyUnitAddress();
        $addresses = [
            $companyUnitAddressTransfer->getAddress1(),
            $companyUnitAddressTransfer->getAddress2(),
            $companyUnitAddressTransfer->getAddress3(),
        ];

        if ($this->requiredCompanyUnitAddressFieldsProvided($companyUnitAddressTransfer) === true) {
            $errorMessage = static::ERROR_MESSAGE_REQUIRED_COMPANY_UNIT_ADDRESS_FIELDS;

            return $this->createCompanyBusinessUnitCsvImportDataErrorTransfer(
                $companyBusinessUnitImportTransfer,
                $errorMessage,
            );
        }

        foreach ($addresses as $address) {
            if ($this->isStringValid255($address) === false) {
                $errorMessage = sprintf(
                    static::ERROR_MESSAGE_COMPANY_UNIT_ADDRESS_ADDRESS_STRING_255,
                    $address,
                );

                return $this->createCompanyBusinessUnitCsvImportDataErrorTransfer(
                    $companyBusinessUnitImportTransfer,
                    $errorMessage,
                );
            }
        }

        if ($this->isIso2CodeValid($companyUnitAddressTransfer->getIso2Code()) === false) {
            $errorMessage = sprintf(
                static::ERROR_MESSAGE_COMPANY_UNIT_ADDRESS_ISO2_CODE_NOT_VALID,
                $companyUnitAddressTransfer->getIso2Code(),
            );

            return $this->createCompanyBusinessUnitCsvImportDataErrorTransfer(
                $companyBusinessUnitImportTransfer,
                $errorMessage,
            );
        }

        if ($this->isStringValid255($companyUnitAddressTransfer->getState()) === false) {
            $errorMessage = sprintf(
                static::ERROR_MESSAGE_COMPANY_UNIT_ADDRESS_STATE_STRING_255,
                $companyUnitAddressTransfer->getState(),
            );

            return $this->createCompanyBusinessUnitCsvImportDataErrorTransfer(
                $companyBusinessUnitImportTransfer,
                $errorMessage,
            );
        }

        if ($this->isStringValid255($companyUnitAddressTransfer->getCity()) === false) {
            $errorMessage = sprintf(
                static::ERROR_MESSAGE_COMPANY_UNIT_ADDRESS_CITY_STRING_255,
                $companyUnitAddressTransfer->getCity(),
            );

            return $this->createCompanyBusinessUnitCsvImportDataErrorTransfer(
                $companyBusinessUnitImportTransfer,
                $errorMessage,
            );
        }

        if ($this->isNumericValid15($companyUnitAddressTransfer->getZipCode()) === false) {
            $errorMessage = sprintf(
                static::ERROR_MESSAGE_COMPANY_UNIT_ADDRESS_ZIP_CODE_NUMERIC_15,
                $companyUnitAddressTransfer->getZipCode(),
            );

            return $this->createCompanyBusinessUnitCsvImportDataErrorTransfer(
                $companyBusinessUnitImportTransfer,
                $errorMessage,
            );
        }

        return null;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUnitAddressTransfer $companyUnitAddressTransfer
     *
     * @return bool
     */
    protected function requiredCompanyUnitAddressFieldsProvided(CompanyUnitAddressTransfer $companyUnitAddressTransfer): bool
    {
        return empty($companyUnitAddressTransfer->getKey()) || empty($companyUnitAddressTransfer->getIso2Code());
    }

    /**
     * @param string $countryName
     *
     * @return bool
     */
    protected function isIso2CodeValid(string $countryName): bool
    {
        $countries = $this->countryFacade->getAvailableCountries();

        foreach ($countries->getCountries() as $country) {
            if ($country->getIso2Code() === $countryName) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $zipCode
     *
     * @return bool
     */
    protected function isNumericValid15(string $zipCode): bool
    {
        if (!is_numeric($zipCode) || strlen($zipCode) > 15) {
            return false;
        }

        return true;
    }
}
