<?php

declare(strict_types=1);

namespace PyzTest\Zed\CustomerCsvImport\Business\Customer\CsvImportDataValidator;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyUnitAddressTransfer;
use Generated\Shared\Transfer\CountryCollectionTransfer;
use Generated\Shared\Transfer\CountryTransfer;
use Generated\Shared\Transfer\CustomerImportTransfer;
use Generated\Shared\Transfer\CustomerListImportErrorTransfer;
use Pyz\Zed\CustomerCsvImport\Business\Customer\CsvImportDataValidator\CompanyUnitAddressCsvDataValidator;
use PyzTest\Zed\CustomerCsvImport\_config\CustomerCsvImportTestConfig;
use PyzTest\Zed\CustomerCsvImport\CustomerCsvImportBusinessTester;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Zed
 * @group CustomerCsvImport
 * @group Business
 * @group Customer
 * @group CompanyUnitAddressCsvDataValidatorTest
 * Add your own group annotations below this line
 */
class CompanyUnitAddressCsvDataValidatorTest extends Unit
{
    /**
     * @var \PyzTest\Zed\CustomerCsvImport\CustomerCsvImportBusinessTester
     */
    protected CustomerCsvImportBusinessTester $tester;

    /**
     * @throws \Exception !
     *
     * @return void
     */
    public function testValidateCustomerImportTransferWithMissingFieldsForCompanyUnitAddressCsvDataValidator(): void
    {
        // Arrange
        $validator = $this->getCompanyUnitAddressCsvDataValidator();
        $companyUnitAddressTransfer = (new CompanyUnitAddressTransfer())
            ->setKey(CustomerCsvImportTestConfig::ADDRESS_ID)
            ->setAddress1(CustomerCsvImportTestConfig::ADDRESS1)
            ->setAddress2(CustomerCsvImportTestConfig::ADDRESS2)
            ->setAddress3(CustomerCsvImportTestConfig::ADDRESS3);

        $customerImportTransfer = (new CustomerImportTransfer())->setCompanyUnitAddress($companyUnitAddressTransfer);

        // Act
        $error = $validator->validateCustomerImportTransfer($customerImportTransfer);

        // Assert
        $this->assertInstanceOf(CustomerListImportErrorTransfer::class, $error);
        $this->assertEquals(
            CompanyUnitAddressCsvDataValidator::ERROR_MESSAGE_REQUIRED_COMPANY_UNIT_ADDRESS_FIELDS,
            $error->getMessage()
        );
    }

    /**
     * @throws \Exception !
     *
     * @return void
     */
    public function testValidateCustomerImportTransferWithValidDataForCompanyUnitAddressCsvDataValidator(): void
    {
        // Arrange
        $validator = $this->getCompanyUnitAddressCsvDataValidator();

        $companyUnitAddressTransfer = (new CompanyUnitAddressTransfer())
            ->setKey(CustomerCsvImportTestConfig::ADDRESS_ID)
            ->setAddress1(CustomerCsvImportTestConfig::ADDRESS1)
            ->setAddress2(CustomerCsvImportTestConfig::ADDRESS2)
            ->setAddress3(CustomerCsvImportTestConfig::ADDRESS3)
            ->setIso2Code(CustomerCsvImportTestConfig::COUNTRY_ISO2_CODE)
            ->setState(CustomerCsvImportTestConfig::STATE)
            ->setCity(CustomerCsvImportTestConfig::CITY)
            ->setZipCode(CustomerCsvImportTestConfig::ZIP_CODE)
            ->setPhone(CustomerCsvImportTestConfig::PHONE);

        $customerImportTransfer = (new CustomerImportTransfer())->setCompanyUnitAddress($companyUnitAddressTransfer);

        // Act
        $error = $validator->validateCustomerImportTransfer($customerImportTransfer);

        // Assert
        $this->assertNull($error);
    }

    /**
     * @throws \Exception !
     *
     * @return \Pyz\Zed\CustomerCsvImport\Business\Customer\CsvImportDataValidator\CompanyUnitAddressCsvDataValidator
     */
    protected function getCompanyUnitAddressCsvDataValidator(): CompanyUnitAddressCsvDataValidator
    {
        /** @var \Spryker\Zed\Country\Business\CountryFacadeInterface $countryFacade */
        $countryFacade = $this->tester->mockFacadeMethod(
            'getAvailableCountries',
            $this->createAvailableCountries(),
            'Country'
        );

        return new CompanyUnitAddressCsvDataValidator($countryFacade);
    }

    /**
     * @return \Generated\Shared\Transfer\CountryCollectionTransfer
     */
    protected function createAvailableCountries(): CountryCollectionTransfer
    {
        $countryCollectionTransfer = new CountryCollectionTransfer();

        $countryTransfer1 = (new CountryTransfer())->setIso2Code(CustomerCsvImportTestConfig::COUNTRY_ISO2_CODE);
        $countryTransfer2 = (new CountryTransfer())->setIso2Code('FR');

        $countryCollectionTransfer->addCountries($countryTransfer1);
        $countryCollectionTransfer->addCountries($countryTransfer2);

        return $countryCollectionTransfer;
    }
}
