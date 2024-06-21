<?php

declare(strict_types=1);

namespace PyzTest\Zed\CustomerCsvImport\Business\Customer\CsvImportDataValidator;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CustomerImportTransfer;
use Generated\Shared\Transfer\CustomerListImportErrorTransfer;
use Generated\Shared\Transfer\StoreRelationTransfer;
use Pyz\Zed\CustomerCsvImport\Business\Customer\CsvImportDataValidator\CompanyCsvDataValidator;
use PyzTest\Zed\CustomerCsvImport\_config\CustomerCsvImportTestConfig;

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
    public function testValidateCustomerImportTransferWithMissingFieldsForCompanyCsvDataValidator(): void
    {
        // Arrange
        $validator = $this->getCompanyCsvDataValidator();
        $companyTransfer = new CompanyTransfer();
        $companyTransfer->setKey(CustomerCsvImportTestConfig::BRAND_ID);
        $customerImportTransfer = (new CustomerImportTransfer())->setCompany($companyTransfer);

        // Act
        $error = $validator->validateCustomerImportTransfer($customerImportTransfer);

        // Assert
        $this->assertInstanceOf(CustomerListImportErrorTransfer::class, $error);
        $this->assertEquals(
            CompanyCsvDataValidator::ERROR_MESSAGE_REQUIRED_COMPANY_FIELDS,
            $error->getMessage()
        );
    }

    /**
     * @return void
     */
    public function testValidateCustomerImportTransferWithValidDataForCompanyCsvDataValidator(): void
    {
        // Arrange
        $validator = $this->getCompanyCsvDataValidator();
        $storeRelationTransfer = new StoreRelationTransfer();
        $storeRelationTransfer->setIdStores([1]);

        $companyTransfer = (new CompanyTransfer())
            ->setKey(CustomerCsvImportTestConfig::BRAND_ID)
            ->setName(CustomerCsvImportTestConfig::BRAND_NAME)
            ->setIsActive(CustomerCsvImportTestConfig::BRAND_ACTIVE)
            ->setStatus(CustomerCsvImportTestConfig::BRAND_STATUS)
            ->setStoreName(CustomerCsvImportTestConfig::BRAND_MARKET)
            ->setStoreRelation($storeRelationTransfer);

        $customerImportTransfer = (new CustomerImportTransfer())->setCompany($companyTransfer);

        // Act
        $error = $validator->validateCustomerImportTransfer($customerImportTransfer);

        // Assert
        $this->assertNull($error);
    }

    /**
     * @return \Pyz\Zed\CustomerCsvImport\Business\Customer\CsvImportDataValidator\CompanyCsvDataValidator
     */
    protected function getCompanyCsvDataValidator(): CompanyCsvDataValidator
    {
        return new CompanyCsvDataValidator();
    }
}
