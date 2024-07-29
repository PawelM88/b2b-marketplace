<?php

declare(strict_types=1);

namespace PyzTest\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnitCsvImport;

use Codeception\Test\Unit;
use PHPUnit\Framework\MockObject\MockObject;
use Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CompanyBusinessUnitCsvImportMapper;
use Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CompanyBusinessUnitCsvImportMapperInterface;
use Pyz\Zed\CompanyBusinessUnitCsvImport\CompanyBusinessUnitCsvImportConfig;
use PyzTest\Zed\CompanyBusinessUnitCsvImport\_config\CompanyBusinessUnitCsvImportTestConfig;

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
class CompanyBusinessUnitCsvImportMapperTest extends Unit
{
    /**
     * @var \Pyz\Zed\CompanyBusinessUnitCsvImport\CompanyBusinessUnitCsvImportConfig
     */
    protected CompanyBusinessUnitCsvImportConfig $configMock;

    /**
     * @return void
     */
    public function testCompanyBusinessUnitCsvImportMapperReturnCorrectCompanyBusinessUnitImportTransfer(): void
    {
        // Arrange
        $mapper = $this->getCompanyBusinessUnitCsvImportMapper();
        $combinedImportData = $this->createCombinedImportDataArray();

        // Act
        $companyBusinessUnitImportTransfer = $mapper->mapCompanyBusinessUnitRowToCompanyBusinessUnitImportTransfer(
            $combinedImportData
        );

        // Assert
        $this->assertEquals(
            CompanyBusinessUnitCsvImportTestConfig::BRAND_NAME,
            $companyBusinessUnitImportTransfer->getCompany()->getName()
        );
        $this->assertEquals(
            CompanyBusinessUnitCsvImportTestConfig::SHIP_TO_NAME,
            $companyBusinessUnitImportTransfer->getCompanyBusinessUnit()->getName()
        );
        $this->assertEquals(
            CompanyBusinessUnitCsvImportTestConfig::SOLD_TO_ID,
            $companyBusinessUnitImportTransfer->getCompanyBusinessUnit()->getParentCompanyBusinessUnitKey()
        );
        $this->assertEquals(
            CompanyBusinessUnitCsvImportTestConfig::STATE,
            $companyBusinessUnitImportTransfer->getCompanyUnitAddress()->getState()
        );
        $this->assertEquals(
            CompanyBusinessUnitCsvImportTestConfig::ADMIN_FIRST_NAME,
            $companyBusinessUnitImportTransfer->getCustomer()->getFirstName()
        );
    }

    /**
     * @return \Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CompanyBusinessUnitCsvImportMapperInterface
     */
    protected function getCompanyBusinessUnitCsvImportMapper(): CompanyBusinessUnitCsvImportMapperInterface
    {
        return new CompanyBusinessUnitCsvImportMapper(
            $this->getConfigMock(),
        );
    }

    /**
     * @return \PHPUnit\Framework\MockObject\MockObject|\Pyz\Zed\CompanyBusinessUnitCsvImport\CompanyBusinessUnitCsvImportConfig
     */
    protected function getConfigMock(): MockObject|CompanyBusinessUnitCsvImportConfig
    {
        return $this->configMock = $this->createMock(CompanyBusinessUnitCsvImportConfig::class);
    }

    /**
     * @return string[]
     */
    protected function createCombinedImportDataArray(): array
    {
        return [
            CompanyBusinessUnitCsvImportConfig::BRAND_ID => CompanyBusinessUnitCsvImportTestConfig::BRAND_ID,
            CompanyBusinessUnitCsvImportConfig::BRAND_NAME => CompanyBusinessUnitCsvImportTestConfig::BRAND_NAME,
            CompanyBusinessUnitCsvImportConfig::BRAND_ACTIVE => CompanyBusinessUnitCsvImportTestConfig::BRAND_ACTIVE,
            CompanyBusinessUnitCsvImportConfig::BRAND_STATUS => CompanyBusinessUnitCsvImportTestConfig::BRAND_STATUS,
            CompanyBusinessUnitCsvImportConfig::BRAND_MARKET => CompanyBusinessUnitCsvImportTestConfig::BRAND_MARKET,
            CompanyBusinessUnitCsvImportConfig::SOLD_TO_ID => CompanyBusinessUnitCsvImportTestConfig::SOLD_TO_ID,
            CompanyBusinessUnitCsvImportConfig::SOLD_TO_NAME => CompanyBusinessUnitCsvImportTestConfig::SOLD_TO_NAME,
            CompanyBusinessUnitCsvImportConfig::SHIP_TO_ID => CompanyBusinessUnitCsvImportTestConfig::SHIP_TO_ID,
            CompanyBusinessUnitCsvImportConfig::SHIP_TO_NAME => CompanyBusinessUnitCsvImportTestConfig::SHIP_TO_NAME,
            CompanyBusinessUnitCsvImportConfig::EMAIL => CompanyBusinessUnitCsvImportTestConfig::EMAIL,
            CompanyBusinessUnitCsvImportConfig::PHONE => CompanyBusinessUnitCsvImportTestConfig::PHONE,
            CompanyBusinessUnitCsvImportConfig::ADDRESS_ID => CompanyBusinessUnitCsvImportTestConfig::ADDRESS_ID,
            CompanyBusinessUnitCsvImportConfig::ADDRESS1 => CompanyBusinessUnitCsvImportTestConfig::ADDRESS1,
            CompanyBusinessUnitCsvImportConfig::ADDRESS2 => CompanyBusinessUnitCsvImportTestConfig::ADDRESS2,
            CompanyBusinessUnitCsvImportConfig::ADDRESS3 => CompanyBusinessUnitCsvImportTestConfig::ADDRESS3,
            CompanyBusinessUnitCsvImportConfig::COUNTRY_ISO2_CODE => CompanyBusinessUnitCsvImportTestConfig::COUNTRY_ISO2_CODE,
            CompanyBusinessUnitCsvImportConfig::STATE => CompanyBusinessUnitCsvImportTestConfig::STATE,
            CompanyBusinessUnitCsvImportConfig::CITY => CompanyBusinessUnitCsvImportTestConfig::CITY,
            CompanyBusinessUnitCsvImportConfig::ZIP_CODE => CompanyBusinessUnitCsvImportTestConfig::ZIP_CODE,
            CompanyBusinessUnitCsvImportConfig::ADMIN_SALUTATION => CompanyBusinessUnitCsvImportTestConfig::ADMIN_SALUTATION,
            CompanyBusinessUnitCsvImportConfig::ADMIN_FIRST_NAME => CompanyBusinessUnitCsvImportTestConfig::ADMIN_FIRST_NAME,
            CompanyBusinessUnitCsvImportConfig::ADMIN_LAST_NAME => CompanyBusinessUnitCsvImportTestConfig::ADMIN_LAST_NAME,
            CompanyBusinessUnitCsvImportConfig::ADMIN_EMAIL => CompanyBusinessUnitCsvImportTestConfig::ADMIN_EMAIL,
            CompanyBusinessUnitCsvImportConfig::ADMIN_PHONE => CompanyBusinessUnitCsvImportTestConfig::ADMIN_PHONE,
        ];
    }
}
