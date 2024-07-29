<?php

declare(strict_types=1);

namespace PyzTest\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnitCsvImport\CompanyBusinessUnitCsvImportDataValidator;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyBusinessUnitImportTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitListImportErrorTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\StoreRelationTransfer;
use Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CsvImportDataValidator\CompanyCsvDataValidator;
use PyzTest\Zed\CompanyBusinessUnitCsvImport\_config\CompanyBusinessUnitCsvImportTestConfig;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Zed
 * @group CustomerCsvImport
 * @group Business
 * @group Customer
 * @group CompanyCsvDataValidatorTest
 * Add your own group annotations below this line
 */
class CompanyCsvDataValidatorTest extends Unit
{
    /**
     * @return void
     */
    public function testValidateCompanyBusinessUnitImportTransferWithMissingFieldsForCompanyCsvDataValidator(): void
    {
        // Arrange
        $validator = $this->getCompanyCsvDataValidator();
        $companyTransfer = new CompanyTransfer();
        $companyTransfer->setKey(CompanyBusinessUnitCsvImportTestConfig::BRAND_ID);
        $companyBusinessUnitImportTransfer = (new CompanyBusinessUnitImportTransfer())->setCompany($companyTransfer);

        // Act
        $error = $validator->validateCompanyBusinessUnitImportTransfer($companyBusinessUnitImportTransfer);

        // Assert
        $this->assertInstanceOf(CompanyBusinessUnitListImportErrorTransfer::class, $error);
        $this->assertEquals(
            CompanyCsvDataValidator::ERROR_MESSAGE_REQUIRED_COMPANY_FIELDS,
            $error->getMessage()
        );
    }

    /**
     * @return void
     */
    public function testValidateCompanyBusinessUnitImportTransferWithValidDataForCompanyCsvDataValidator(): void
    {
        // Arrange
        $validator = $this->getCompanyCsvDataValidator();
        $storeRelationTransfer = new StoreRelationTransfer();
        $storeRelationTransfer->setIdStores([1]);

        $companyTransfer = (new CompanyTransfer())
            ->setKey(CompanyBusinessUnitCsvImportTestConfig::BRAND_ID)
            ->setName(CompanyBusinessUnitCsvImportTestConfig::BRAND_NAME)
            ->setIsActive(CompanyBusinessUnitCsvImportTestConfig::BRAND_ACTIVE)
            ->setStatus(CompanyBusinessUnitCsvImportTestConfig::BRAND_STATUS)
            ->setStoreName(CompanyBusinessUnitCsvImportTestConfig::BRAND_MARKET)
            ->setStoreRelation($storeRelationTransfer);

        $companyBusinessUnitImportTransfer = (new CompanyBusinessUnitImportTransfer())->setCompany($companyTransfer);

        // Act
        $error = $validator->validateCompanyBusinessUnitImportTransfer($companyBusinessUnitImportTransfer);

        // Assert
        $this->assertNull($error);
    }

    /**
     * @return \Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CsvImportDataValidator\CompanyCsvDataValidator
     */
    protected function getCompanyCsvDataValidator(): CompanyCsvDataValidator
    {
        return new CompanyCsvDataValidator();
    }
}
