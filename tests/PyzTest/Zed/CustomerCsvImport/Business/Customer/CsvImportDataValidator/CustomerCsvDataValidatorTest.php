<?php

declare(strict_types=1);

namespace PyzTest\Zed\CustomerCsvImport\Business\Customer\CsvImportDataValidator;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CustomerImportTransfer;
use Generated\Shared\Transfer\CustomerListImportErrorTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Pyz\Zed\CustomerCsvImport\Business\Customer\CsvImportDataValidator\CustomerCsvDataValidator;
use PyzTest\Zed\CustomerCsvImport\_config\CustomerCsvImportTestConfig;

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
    public function testValidateCustomerImportTransferWithMissingFieldsForCustomerCsvDataValidator(): void
    {
        // Arrange
        $validator = $this->getCompanyUnitAddressCsvDataValidator();
        $customerTransfer = (new CustomerTransfer())
            ->setSalutation(CustomerCsvImportTestConfig::ADMIN_SALUTATION);

        $customerImportTransfer = (new CustomerImportTransfer())->setCustomer($customerTransfer);

        // Act
        $error = $validator->validateCustomerImportTransfer($customerImportTransfer);

        // Assert
        $this->assertInstanceOf(CustomerListImportErrorTransfer::class, $error);
        $this->assertEquals(
            CustomerCsvDataValidator::ERROR_MESSAGE_REQUIRED_CUSTOMER_FIELDS,
            $error->getMessage()
        );
    }

    /**
     * @return void
     */
    public function testValidateCustomerImportTransferWithValidDataForCustomerCsvDataValidator(): void
    {
        // Arrange
        $validator = $this->getCompanyUnitAddressCsvDataValidator();
        $customerTransfer = (new CustomerTransfer())
            ->setSalutation(CustomerCsvImportTestConfig::ADMIN_SALUTATION)
            ->setFirstName(CustomerCsvImportTestConfig::ADMIN_FIRST_NAME)
            ->setLastName(CustomerCsvImportTestConfig::ADMIN_LAST_NAME)
            ->setEmail(CustomerCsvImportTestConfig::ADMIN_EMAIL)
            ->setPhone(CustomerCsvImportTestConfig::ADMIN_PHONE)
            ->setGender(CustomerCsvImportTestConfig::ADMIN_GENDER);

        $customerImportTransfer = (new CustomerImportTransfer())->setCustomer($customerTransfer);

        // Act
        $error = $validator->validateCustomerImportTransfer($customerImportTransfer);

        // Assert
        $this->assertNull($error);
    }

    /**
     * @return \Pyz\Zed\CustomerCsvImport\Business\Customer\CsvImportDataValidator\CustomerCsvDataValidator
     */
    protected function getCompanyUnitAddressCsvDataValidator(): CustomerCsvDataValidator
    {
        return new CustomerCsvDataValidator();
    }
}
