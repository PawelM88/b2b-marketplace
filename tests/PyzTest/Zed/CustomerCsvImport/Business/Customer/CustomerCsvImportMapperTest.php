<?php

declare(strict_types=1);

namespace PyzTest\Zed\CustomerCsvImport\Business\Customer;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Pyz\Zed\CustomerCsvImport\Business\Customer\CustomerCsvImportMapper;
use Pyz\Zed\CustomerCsvImport\Business\Customer\CustomerCsvImportMapperInterface;
use Pyz\Zed\CustomerCsvImport\CustomerCsvImportConfig;
use PyzTest\Zed\CustomerCsvImport\_config\CustomerCsvImportTestConfig;

/**
 * Auto-generated group annotations
 *
 * @group PyzTest
 * @group Zed
 * @group CustomerCsvImport
 * @group Business
 * @group Customer
 * @group CustomerCsvImportMapperTest
 * Add your own group annotations below this line
 */
class CustomerCsvImportMapperTest extends Unit
{
    /**
     * @var \Pyz\Zed\CustomerCsvImport\CustomerCsvImportConfig
     */
    protected CustomerCsvImportConfig $configMock;

    /**
     * @return void
     */
    public function testCustomerCsvImportMapperReturnCorrectCustomerImportTransfer(): void
    {
        // Arrange
        $mapper = $this->getCustomerCsvImportMapper();
        $combinedImportData = $this->createCombinedImportDataArray();

        // Act
        $customerImportTransfer = $mapper->mapCustomerRowToCustomerImportTransfer($combinedImportData);

        // Assert
        $this->assertEquals(CustomerCsvImportTestConfig::BRAND_NAME, $customerImportTransfer->getCompany()->getName());
        $this->assertEquals(
            CustomerCsvImportTestConfig::SHIP_TO_NAME,
            $customerImportTransfer->getCompanyBusinessUnit()->getName()
        );
        $this->assertEquals(
            CustomerCsvImportTestConfig::SOLD_TO_ID,
            $customerImportTransfer->getCompanyBusinessUnit()->getParentCompanyBusinessUnitKey()
        );
        $this->assertEquals(
            CustomerCsvImportTestConfig::STATE,
            $customerImportTransfer->getCompanyUnitAddress()->getState()
        );
        $this->assertEquals(
            CustomerCsvImportTestConfig::ADMIN_FIRST_NAME,
            $customerImportTransfer->getCustomer()->getFirstName()
        );
    }

    /**
     * @return \Pyz\Zed\CustomerCsvImport\Business\Customer\CustomerCsvImportMapperInterface
     */
    protected function getCustomerCsvImportMapper(): CustomerCsvImportMapperInterface
    {
        return new CustomerCsvImportMapper(
            $this->getConfigMock(),
        );
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\Pyz\Zed\CustomerCsvImport\CustomerCsvImportConfig
     */
    protected function getConfigMock(): MockObject|CustomerCsvImportConfig
    {
        return $this->configMock = $this->createMock(CustomerCsvImportConfig::class);
    }

    /**
     * @return string[]
     */
    protected function createCombinedImportDataArray(): array
    {
        return [
            CustomerCsvImportConfig::BRAND_ID => CustomerCsvImportTestConfig::BRAND_ID,
            CustomerCsvImportConfig::BRAND_NAME => CustomerCsvImportTestConfig::BRAND_NAME,
            CustomerCsvImportConfig::BRAND_ACTIVE => CustomerCsvImportTestConfig::BRAND_ACTIVE,
            CustomerCsvImportConfig::BRAND_STATUS => CustomerCsvImportTestConfig::BRAND_STATUS,
            CustomerCsvImportConfig::BRAND_MARKET => CustomerCsvImportTestConfig::BRAND_MARKET,
            CustomerCsvImportConfig::SOLD_TO_ID => CustomerCsvImportTestConfig::SOLD_TO_ID,
            CustomerCsvImportConfig::SOLD_TO_NAME => CustomerCsvImportTestConfig::SOLD_TO_NAME,
            CustomerCsvImportConfig::SHIP_TO_ID => CustomerCsvImportTestConfig::SHIP_TO_ID,
            CustomerCsvImportConfig::SHIP_TO_NAME => CustomerCsvImportTestConfig::SHIP_TO_NAME,
            CustomerCsvImportConfig::EMAIL => CustomerCsvImportTestConfig::EMAIL,
            CustomerCsvImportConfig::PHONE => CustomerCsvImportTestConfig::PHONE,
            CustomerCsvImportConfig::ADDRESS_ID => CustomerCsvImportTestConfig::ADDRESS_ID,
            CustomerCsvImportConfig::ADDRESS1 => CustomerCsvImportTestConfig::ADDRESS1,
            CustomerCsvImportConfig::ADDRESS2 => CustomerCsvImportTestConfig::ADDRESS2,
            CustomerCsvImportConfig::ADDRESS3 => CustomerCsvImportTestConfig::ADDRESS3,
            CustomerCsvImportConfig::COUNTRY_ISO2_CODE => CustomerCsvImportTestConfig::COUNTRY_ISO2_CODE,
            CustomerCsvImportConfig::STATE => CustomerCsvImportTestConfig::STATE,
            CustomerCsvImportConfig::CITY => CustomerCsvImportTestConfig::CITY,
            CustomerCsvImportConfig::ZIP_CODE => CustomerCsvImportTestConfig::ZIP_CODE,
            CustomerCsvImportConfig::ADMIN_SALUTATION => CustomerCsvImportTestConfig::ADMIN_SALUTATION,
            CustomerCsvImportConfig::ADMIN_FIRST_NAME => CustomerCsvImportTestConfig::ADMIN_FIRST_NAME,
            CustomerCsvImportConfig::ADMIN_LAST_NAME => CustomerCsvImportTestConfig::ADMIN_LAST_NAME,
            CustomerCsvImportConfig::ADMIN_EMAIL => CustomerCsvImportTestConfig::ADMIN_EMAIL,
            CustomerCsvImportConfig::ADMIN_PHONE => CustomerCsvImportTestConfig::ADMIN_PHONE,
            CustomerCsvImportConfig::ADMIN_GENDER => CustomerCsvImportTestConfig::ADMIN_GENDER,
        ];
    }
}
