<?php

declare(strict_types=1);

namespace PyzTest\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnitCsvImport\CompanyBusinessUnitCsvImportDataValidator;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyBusinessUnitImportTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitListImportErrorTransfer;
use Generated\Shared\Transfer\CompanyUnitAddressTransfer;
use Generated\Shared\Transfer\CountryCollectionTransfer;
use Generated\Shared\Transfer\CountryTransfer;
use Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CsvImportDataValidator\CompanyUnitAddressCsvDataValidator;
use PyzTest\Zed\CompanyBusinessUnitCsvImport\_config\CompanyBusinessUnitCsvImportTestConfig;
use PyzTest\Zed\CompanyBusinessUnitCsvImport\CompanyBusinessUnitCsvImportBusinessTester;

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
     * @var \PyzTest\Zed\CompanyBusinessUnitCsvImport\CompanyBusinessUnitCsvImportBusinessTester
     */
    protected CompanyBusinessUnitCsvImportBusinessTester $tester;

    /**
     * @throws \Exception !
     *
     * @return void
     */
    public function testValidateCompanyBusinessUnitImportTransferWithMissingFieldsForCompanyUnitAddressCsvDataValidator(
    ): void
    {
        // Arrange
        $validator = $this->getCompanyUnitAddressCsvDataValidator();
        $companyUnitAddressTransfer = (new CompanyUnitAddressTransfer())
            ->setKey(CompanyBusinessUnitCsvImportTestConfig::ADDRESS_ID)
            ->setAddress1(CompanyBusinessUnitCsvImportTestConfig::ADDRESS1)
            ->setAddress2(CompanyBusinessUnitCsvImportTestConfig::ADDRESS2)
            ->setAddress3(CompanyBusinessUnitCsvImportTestConfig::ADDRESS3);

        $companyBusinessUnitImportTransfer = (new CompanyBusinessUnitImportTransfer())->setCompanyUnitAddress(
            $companyUnitAddressTransfer
        );

        // Act
        $error = $validator->validateCompanyBusinessUnitImportTransfer($companyBusinessUnitImportTransfer);

        // Assert
        $this->assertInstanceOf(CompanyBusinessUnitListImportErrorTransfer::class, $error);
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
    public function testValidateCompanyBusinessUnitImportTransferWithValidDataForCompanyUnitAddressCsvDataValidator(
    ): void
    {
        // Arrange
        $validator = $this->getCompanyUnitAddressCsvDataValidator();

        $companyUnitAddressTransfer = (new CompanyUnitAddressTransfer())
            ->setKey(CompanyBusinessUnitCsvImportTestConfig::ADDRESS_ID)
            ->setAddress1(CompanyBusinessUnitCsvImportTestConfig::ADDRESS1)
            ->setAddress2(CompanyBusinessUnitCsvImportTestConfig::ADDRESS2)
            ->setAddress3(CompanyBusinessUnitCsvImportTestConfig::ADDRESS3)
            ->setIso2Code(CompanyBusinessUnitCsvImportTestConfig::COUNTRY_ISO2_CODE)
            ->setState(CompanyBusinessUnitCsvImportTestConfig::STATE)
            ->setCity(CompanyBusinessUnitCsvImportTestConfig::CITY)
            ->setZipCode(CompanyBusinessUnitCsvImportTestConfig::ZIP_CODE)
            ->setPhone(CompanyBusinessUnitCsvImportTestConfig::PHONE);

        $companyBusinessUnitImportTransfer = (new CompanyBusinessUnitImportTransfer())->setCompanyUnitAddress(
            $companyUnitAddressTransfer
        );

        // Act
        $error = $validator->validateCompanyBusinessUnitImportTransfer($companyBusinessUnitImportTransfer);

        // Assert
        $this->assertNull($error);
    }

    /**
     * @throws \Exception !
     *
     * @return \Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CsvImportDataValidator\CompanyUnitAddressCsvDataValidator
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

        $countryTransfer1 = (new CountryTransfer())->setIso2Code(
            CompanyBusinessUnitCsvImportTestConfig::COUNTRY_ISO2_CODE
        );
        $countryTransfer2 = (new CountryTransfer())->setIso2Code('FR');

        $countryCollectionTransfer->addCountries($countryTransfer1);
        $countryCollectionTransfer->addCountries($countryTransfer2);

        return $countryCollectionTransfer;
    }
}
