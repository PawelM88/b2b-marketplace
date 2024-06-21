<?php

declare(strict_types=1);

namespace PyzTest\Zed\CustomerCsvImport\Business\Customer\CsvImportDataValidator;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\CustomerImportTransfer;
use Generated\Shared\Transfer\CustomerListImportErrorTransfer;
use Pyz\Zed\CustomerCsvImport\Business\Customer\CsvImportDataValidator\CompanyBusinessUnitCsvDataValidator;
use PyzTest\Zed\CustomerCsvImport\_config\CustomerCsvImportTestConfig;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Zed
 * @group CustomerCsvImport
 * @group Business
 * @group Customer
 * @group CompanyBusinessUnitCsvDataValidatorTest
 * Add your own group annotations below this line
 */
class CompanyBusinessUnitCsvDataValidatorTest extends Unit
{
    /**
     * @return void
     */
    public function testValidateCustomerImportTransferWithMissingFieldsForCompanyBusinessUnitCsvDataValidator(): void
    {
        // Arrange
        $validator = $this->getCompanyBusinessUnitCsvDataValidator();
        $companyBusinessUnitTransfer = new CompanyBusinessUnitTransfer();
        $companyBusinessUnitTransfer->setKey(CustomerCsvImportTestConfig::SOLD_TO_ID);
        $customerImportTransfer = (new CustomerImportTransfer())->setCompanyBusinessUnit($companyBusinessUnitTransfer);

        // Act
        $error = $validator->validateCustomerImportTransfer($customerImportTransfer);

        // Assert
        $this->assertInstanceOf(CustomerListImportErrorTransfer::class, $error);
        $this->assertEquals(
            CompanyBusinessUnitCsvDataValidator::ERROR_MESSAGE_REQUIRED_COMPANY_BUSINESS_UNIT_FIELDS,
            $error->getMessage()
        );
    }

    /**
     * @return void
     */
    public function testValidateCustomerImportTransferWithValidDataForCompanyBusinessUnitCsvDataValidator(): void
    {
        // Arrange
        $validator = $this->getCompanyBusinessUnitCsvDataValidator();

        $companyBusinessUnitTransfer = (new CompanyBusinessUnitTransfer())
            ->setKey(CustomerCsvImportTestConfig::SHIP_TO_ID)
            ->setName(CustomerCsvImportTestConfig::SHIP_TO_NAME)
            ->setEmail(CustomerCsvImportTestConfig::EMAIL)
            ->setPhone(CustomerCsvImportTestConfig::PHONE)
            ->setParentCompanyBusinessUnitKey(CustomerCsvImportTestConfig::SOLD_TO_ID);

        $customerImportTransfer = (new CustomerImportTransfer())->setCompanyBusinessUnit($companyBusinessUnitTransfer);

        // Act
        $error = $validator->validateCustomerImportTransfer($customerImportTransfer);

        // Assert
        $this->assertNull($error);
    }

    /**
     * @return \Pyz\Zed\CustomerCsvImport\Business\Customer\CsvImportDataValidator\CompanyBusinessUnitCsvDataValidator
     */
    protected function getCompanyBusinessUnitCsvDataValidator(): CompanyBusinessUnitCsvDataValidator
    {
        return new CompanyBusinessUnitCsvDataValidator();
    }
}
