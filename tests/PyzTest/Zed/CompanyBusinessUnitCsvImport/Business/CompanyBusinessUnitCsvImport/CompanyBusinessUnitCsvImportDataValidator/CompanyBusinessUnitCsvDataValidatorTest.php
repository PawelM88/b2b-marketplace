<?php

declare(strict_types=1);

namespace PyzTest\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnitCsvImport\CompanyBusinessUnitCsvImportDataValidator;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyBusinessUnitImportTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitListImportErrorTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CsvImportDataValidator\CompanyBusinessUnitCsvDataValidator;
use PyzTest\Zed\CompanyBusinessUnitCsvImport\_config\CompanyBusinessUnitCsvImportTestConfig;

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
    public function testValidateCompanyBusinessUnitImportTransferWithMissingFieldsForCompanyBusinessUnitCsvDataValidator(
    ): void
    {
        // Arrange
        $validator = $this->getCompanyBusinessUnitCsvDataValidator();
        $companyBusinessUnitTransfer = new CompanyBusinessUnitTransfer();
        $companyBusinessUnitTransfer->setKey(CompanyBusinessUnitCsvImportTestConfig::SOLD_TO_ID);
        $customerImportTransfer = (new CompanyBusinessUnitImportTransfer())->setCompanyBusinessUnit(
            $companyBusinessUnitTransfer
        );

        // Act
        $error = $validator->validateCompanyBusinessUnitImportTransfer($customerImportTransfer);

        // Assert
        $this->assertInstanceOf(CompanyBusinessUnitListImportErrorTransfer::class, $error);
        $this->assertEquals(
            CompanyBusinessUnitCsvDataValidator::ERROR_MESSAGE_REQUIRED_COMPANY_BUSINESS_UNIT_FIELDS,
            $error->getMessage()
        );
    }

    /**
     * @return void
     */
    public function testValidateCompanyBusinessUnitImportTransferWithValidDataForCompanyBusinessUnitCsvDataValidator(
    ): void
    {
        // Arrange
        $validator = $this->getCompanyBusinessUnitCsvDataValidator();

        $companyBusinessUnitTransfer = (new CompanyBusinessUnitTransfer())
            ->setKey(CompanyBusinessUnitCsvImportTestConfig::SHIP_TO_ID)
            ->setName(CompanyBusinessUnitCsvImportTestConfig::SHIP_TO_NAME)
            ->setEmail(CompanyBusinessUnitCsvImportTestConfig::EMAIL)
            ->setPhone(CompanyBusinessUnitCsvImportTestConfig::PHONE)
            ->setParentCompanyBusinessUnitKey(CompanyBusinessUnitCsvImportTestConfig::SOLD_TO_ID);

        $customerImportTransfer = (new CompanyBusinessUnitImportTransfer())->setCompanyBusinessUnit(
            $companyBusinessUnitTransfer
        );

        // Act
        $error = $validator->validateCompanyBusinessUnitImportTransfer($customerImportTransfer);

        // Assert
        $this->assertNull($error);
    }

    /**
     * @return \Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CsvImportDataValidator\CompanyBusinessUnitCsvDataValidator
     */
    protected function getCompanyBusinessUnitCsvDataValidator(): CompanyBusinessUnitCsvDataValidator
    {
        return new CompanyBusinessUnitCsvDataValidator();
    }
}
