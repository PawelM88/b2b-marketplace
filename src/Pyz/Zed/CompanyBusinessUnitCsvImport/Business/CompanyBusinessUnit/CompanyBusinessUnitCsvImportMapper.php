<?php

declare(strict_types=1);

namespace Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit;

use ArrayObject;
use Generated\Shared\Transfer\CompanyBusinessUnitImportMetaDataTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitImportTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyUnitAddressTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\SpyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer;
use Generated\Shared\Transfer\StoreRelationTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use Pyz\Zed\CompanyBusinessUnitCsvImport\CompanyBusinessUnitCsvImportConfig;

class CompanyBusinessUnitCsvImportMapper implements CompanyBusinessUnitCsvImportMapperInterface
{
    /**
     * @param \Pyz\Zed\CompanyBusinessUnitCsvImport\CompanyBusinessUnitCsvImportConfig $companyBusinessUnitCsvImporterConfig
     */
    public function __construct(
        protected CompanyBusinessUnitCsvImportConfig $companyBusinessUnitCsvImporterConfig,
    ) {
    }

    /**
     * @param array<string, mixed> $combinedImportData
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitImportTransfer
     */
    public function mapCompanyBusinessUnitRowToCompanyBusinessUnitImportTransfer(array $combinedImportData): CompanyBusinessUnitImportTransfer
    {
        $companyBusinessUnitImportTransfer = new CompanyBusinessUnitImportTransfer();

        $company = $this->mapCompanyBusinessUnitRowToCompanyTransfer($combinedImportData);
        $companyBusinessUnit = $this->mapCompanyBusinessUnitRowToCompanyBusinessUnitTransfer($combinedImportData);
        $companyUnitAddress = $this->mapCompanyBusinessUnitRowToCompanyUnitAddressTransfer($combinedImportData);
        $customer = $this->mapCompanyBusinessUnitRowToCustomerTransfer($combinedImportData);

        $companyBusinessUnitImportTransfer
            ->setCompany($company)
            ->setCompanyBusinessUnit($companyBusinessUnit)
            ->setCompanyUnitAddress($companyUnitAddress)
            ->setCustomer($customer);

        return $companyBusinessUnitImportTransfer
            ->setMetaData(new CompanyBusinessUnitImportMetaDataTransfer());
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitImportTransfer $companyBusinessUnitImportTransfer
     * @param \Generated\Shared\Transfer\StoreTransfer $storeTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitImportTransfer
     */
    public function mapStoreToCompanyTransfer(
        CompanyBusinessUnitImportTransfer $companyBusinessUnitImportTransfer,
        StoreTransfer $storeTransfer,
    ): CompanyBusinessUnitImportTransfer {
        $companyTransfer = $companyBusinessUnitImportTransfer->getCompany();
        $storeRelationTransfer = new StoreRelationTransfer();

        $storeRelationTransfer->setStores(new ArrayObject([$storeTransfer]));
        $storeRelationTransfer->setIdStores([$storeTransfer->getIdStore()]);

        $companyTransfer->setStoreRelation($storeRelationTransfer);
        $companyBusinessUnitImportTransfer->setCompany($companyTransfer);

        return $companyBusinessUnitImportTransfer;
    }

    /**
     * @param array<string, mixed> $combinedImportData
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer
     */
    protected function mapCompanyBusinessUnitRowToCompanyTransfer(array $combinedImportData): CompanyTransfer
    {
        $companyTransfer = new CompanyTransfer();

        $companyTransfer
            ->setKey($combinedImportData[$this->companyBusinessUnitCsvImporterConfig::BRAND_ID])
            ->setName($combinedImportData[$this->companyBusinessUnitCsvImporterConfig::BRAND_NAME])
            ->setIsActive($combinedImportData[$this->companyBusinessUnitCsvImporterConfig::BRAND_ACTIVE])
            ->setStatus($combinedImportData[$this->companyBusinessUnitCsvImporterConfig::BRAND_STATUS])
            ->setStoreName($combinedImportData[$this->companyBusinessUnitCsvImporterConfig::BRAND_MARKET]);

        return $companyTransfer;
    }

    /**
     * @param array<string, mixed> $combinedImportData
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    protected function mapCompanyBusinessUnitRowToCompanyBusinessUnitTransfer(array $combinedImportData): CompanyBusinessUnitTransfer
    {
        $companyBusinessUnitTransfer = new CompanyBusinessUnitTransfer();

        $companyBusinessUnitTransfer
            ->setKey($combinedImportData[$this->companyBusinessUnitCsvImporterConfig::SOLD_TO_ID])
            ->setName($combinedImportData[$this->companyBusinessUnitCsvImporterConfig::SOLD_TO_NAME])
            ->setEmail($combinedImportData[$this->companyBusinessUnitCsvImporterConfig::EMAIL])
            ->setPhone($combinedImportData[$this->companyBusinessUnitCsvImporterConfig::PHONE]);

        if ($combinedImportData[$this->companyBusinessUnitCsvImporterConfig::SHIP_TO_ID]) {
            $companyBusinessUnitTransfer
                ->setParentCompanyBusinessUnitKey($combinedImportData[$this->companyBusinessUnitCsvImporterConfig::SOLD_TO_ID])
                ->setKey($combinedImportData[$this->companyBusinessUnitCsvImporterConfig::SHIP_TO_ID])
                ->setName($combinedImportData[$this->companyBusinessUnitCsvImporterConfig::SHIP_TO_NAME]);
        }

        return $companyBusinessUnitTransfer;
    }

    /**
     * @param array<string, mixed> $combinedImportData
     *
     * @return \Generated\Shared\Transfer\CompanyUnitAddressTransfer
     */
    protected function mapCompanyBusinessUnitRowToCompanyUnitAddressTransfer(array $combinedImportData): CompanyUnitAddressTransfer
    {
        $companyUnitAddressTransfer = new CompanyUnitAddressTransfer();

        $companyUnitAddressTransfer
            ->setKey($combinedImportData[$this->companyBusinessUnitCsvImporterConfig::ADDRESS_ID])
            ->setAddress1($combinedImportData[$this->companyBusinessUnitCsvImporterConfig::ADDRESS1])
            ->setAddress2($combinedImportData[$this->companyBusinessUnitCsvImporterConfig::ADDRESS2])
            ->setAddress3($combinedImportData[$this->companyBusinessUnitCsvImporterConfig::ADDRESS3])
            ->setIso2Code($combinedImportData[$this->companyBusinessUnitCsvImporterConfig::COUNTRY_ISO2_CODE])
            ->setState($combinedImportData[$this->companyBusinessUnitCsvImporterConfig::STATE])
            ->setCity($combinedImportData[$this->companyBusinessUnitCsvImporterConfig::CITY])
            ->setZipCode($combinedImportData[$this->companyBusinessUnitCsvImporterConfig::ZIP_CODE])
            ->setPhone($combinedImportData[$this->companyBusinessUnitCsvImporterConfig::PHONE]);

        return $companyUnitAddressTransfer;
    }

    /**
     * @param array<string, mixed> $combinedImportData
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    protected function mapCompanyBusinessUnitRowToCustomerTransfer(array $combinedImportData): CustomerTransfer
    {
        $customerTransfer = new CustomerTransfer();
        $customerTransfer
            ->setSalutation($combinedImportData[$this->companyBusinessUnitCsvImporterConfig::ADMIN_SALUTATION])
            ->setFirstName($combinedImportData[$this->companyBusinessUnitCsvImporterConfig::ADMIN_FIRST_NAME])
            ->setLastName($combinedImportData[$this->companyBusinessUnitCsvImporterConfig::ADMIN_LAST_NAME])
            ->setEmail($combinedImportData[$this->companyBusinessUnitCsvImporterConfig::ADMIN_EMAIL])
            ->setPhone($combinedImportData[$this->companyBusinessUnitCsvImporterConfig::ADMIN_PHONE]);

        return $customerTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    public function mapCompanyToCompanyBusinessUnit(
        CompanyTransfer $companyTransfer,
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer,
    ): CompanyBusinessUnitTransfer {
        return $companyBusinessUnitTransfer->setFkCompany($companyTransfer->getIdCompany());
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     * @param \Generated\Shared\Transfer\CompanyUnitAddressTransfer $companyUnitAddressTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUnitAddressTransfer
     */
    public function mapCompanyToCompanyUnitAddress(
        CompanyTransfer $companyTransfer,
        CompanyUnitAddressTransfer $companyUnitAddressTransfer,
    ): CompanyUnitAddressTransfer {
        return $companyUnitAddressTransfer->setFkCompany($companyTransfer->getIdCompany());
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
     * @param \Generated\Shared\Transfer\CompanyUnitAddressTransfer $companyUnitAddressTransfer
     *
     * @return \Generated\Shared\Transfer\SpyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer
     */
    public function mapCompanyBusinessUnitAndCompanyUnitAddressToCompanyBusinessUnitAddress(
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer,
        CompanyUnitAddressTransfer $companyUnitAddressTransfer,
    ): SpyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer {
        $spyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer = new SpyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer(
        );
        $spyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer
            ->setFkCompanyBusinessUnit($companyBusinessUnitTransfer->getIdCompanyBusinessUnit())
            ->setFkCompanyUnitAddress(
                $companyUnitAddressTransfer->getIdCompanyUnitAddress(),
            );

        return $spyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUserTransfer
     */
    public function mapCustomerAndCompanyDataToCompanyUser(
        CustomerTransfer $customerTransfer,
        CompanyTransfer $companyTransfer,
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer,
    ): CompanyUserTransfer {
        $companyUserTransfer = new CompanyUserTransfer();
        $companyUserTransfer
            ->setFkCompany($companyTransfer->getIdCompany())
            ->setFkCustomer($customerTransfer->getIdCustomer())
            ->setCompany($companyTransfer)
            ->setCustomer($customerTransfer)
            ->setFkCompanyBusinessUnit($companyBusinessUnitTransfer->getIdCompanyBusinessUnit());

        return $companyUserTransfer;
    }
}
