<?php

declare(strict_types=1);

namespace PyzTest\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnitCsvImport\CompanyBusinessUnitCsvImportDataValidator;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyBusinessUnitImportTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitListImportErrorTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CsvImportDataValidator\CustomerCsvDataValidator;
use PyzTest\Zed\CompanyBusinessUnitCsvImport\_config\CompanyBusinessUnitCsvImportTestConfig;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Zed
 * @group CustomerCsvImport
 * @group Business
 * @group Customer
 * @group CustomerCsvDataValidatorTest
 * Add your own group annotations below this line
 */
class CustomerCsvDataValidatorTest extends Unit
{
    /**
     * @return void
     */
    public function testValidateCompanyBusinessUnitImportTransferWithMissingFieldsForCustomerCsvDataValidator(): void
    {
        // Arrange
        $validator = $this->getCompanyUnitAddressCsvDataValidator();
        $customerTransfer = (new CustomerTransfer())
            ->setSalutation(CompanyBusinessUnitCsvImportTestConfig::ADMIN_SALUTATION);

        $companyBusinessUnitImportTransfer = (new CompanyBusinessUnitImportTransfer())->setCustomer($customerTransfer);

        // Act
        $error = $validator->validateCompanyBusinessUnitImportTransfer($companyBusinessUnitImportTransfer);

        // Assert
        $this->assertInstanceOf(CompanyBusinessUnitListImportErrorTransfer::class, $error);
        $this->assertEquals(
            CustomerCsvDataValidator::ERROR_MESSAGE_REQUIRED_CUSTOMER_FIELDS,
            $error->getMessage()
        );
    }

    /**
     * @return void
     */
    public function testValidateCompanyBusinessUnitImportTransferWithValidDataForCustomerCsvDataValidator(): void
    {
        // Arrange
        $validator = $this->getCompanyUnitAddressCsvDataValidator();
        $customerTransfer = (new CustomerTransfer())
            ->setSalutation(CompanyBusinessUnitCsvImportTestConfig::ADMIN_SALUTATION)
            ->setFirstName(CompanyBusinessUnitCsvImportTestConfig::ADMIN_FIRST_NAME)
            ->setLastName(CompanyBusinessUnitCsvImportTestConfig::ADMIN_LAST_NAME)
            ->setEmail(CompanyBusinessUnitCsvImportTestConfig::ADMIN_EMAIL)
            ->setPhone(CompanyBusinessUnitCsvImportTestConfig::ADMIN_PHONE);

        $companyBusinessUnitImportTransfer = (new CompanyBusinessUnitImportTransfer())->setCustomer($customerTransfer);

        // Act
        $error = $validator->validateCompanyBusinessUnitImportTransfer($companyBusinessUnitImportTransfer);

        // Assert
        $this->assertNull($error);
    }

    /**
     * @return \Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CsvImportDataValidator\CustomerCsvDataValidator
     */
    protected function getCompanyUnitAddressCsvDataValidator(): CustomerCsvDataValidator
    {
        return new CustomerCsvDataValidator();
    }
}
