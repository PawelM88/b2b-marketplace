<?php

declare(strict_types=1);

namespace Pyz\Zed\CustomerCsvImport\Business\Customer;

use ArrayObject;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyUnitAddressTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerImportMetaDataTransfer;
use Generated\Shared\Transfer\CustomerImportTransfer;
use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\SpyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer;
use Generated\Shared\Transfer\StoreRelationTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use Pyz\Zed\CustomerCsvImport\CustomerCsvImportConfig;

class CustomerCsvImportMapper implements CustomerCsvImportMapperInterface
{
    /**
     * @param \Pyz\Zed\CustomerCsvImport\CustomerCsvImportConfig $customerCsvImporterConfig
     */
    public function __construct(
        protected CustomerCsvImportConfig $customerCsvImporterConfig,
    ) {
    }

    /**
     * @param array<string, mixed> $combinedImportData
     *
     * @return \Generated\Shared\Transfer\CustomerImportTransfer
     */
    public function mapCustomerRowToCustomerImportTransfer(array $combinedImportData): CustomerImportTransfer
    {
        $customerImportTransfer = new CustomerImportTransfer();

        $company = $this->mapCustomerRowToCompanyTransfer($combinedImportData);
        $companyBusinessUnit = $this->mapCustomerRowToCompanyBusinessUnitTransfer($combinedImportData);
        $companyUnitAddress = $this->mapCustomerRowToCompanyUnitAddressTransfer($combinedImportData);
        $customer = $this->mapCustomerRowToCustomerTransfer($combinedImportData);

        $customerImportTransfer
            ->setCompany($company)
            ->setCompanyBusinessUnit($companyBusinessUnit)
            ->setCompanyUnitAddress($companyUnitAddress)
            ->setCustomer($customer);

        return $customerImportTransfer
            ->setMetaData(new CustomerImportMetaDataTransfer());
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerImportTransfer $customerImportTransfer
     * @param \Generated\Shared\Transfer\StoreTransfer $storeTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerImportTransfer
     */
    public function mapStoreToCompanyTransfer(
        CustomerImportTransfer $customerImportTransfer,
        StoreTransfer $storeTransfer,
    ): CustomerImportTransfer {
        $companyTransfer = $customerImportTransfer->getCompany();
        $storeRelationTransfer = new StoreRelationTransfer();

        $storeRelationTransfer->setStores(new ArrayObject([$storeTransfer]));
        $storeRelationTransfer->setIdStores([$storeTransfer->getIdStore()]);

        $companyTransfer->setStoreRelation($storeRelationTransfer);
        $customerImportTransfer->setCompany($companyTransfer);

        return $customerImportTransfer;
    }

    /**
     * @param array<string, mixed> $combinedImportData
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer
     */
    protected function mapCustomerRowToCompanyTransfer(array $combinedImportData): CompanyTransfer
    {
        $companyTransfer = new CompanyTransfer();

        $companyTransfer
            ->setKey($combinedImportData[$this->customerCsvImporterConfig::BRAND_ID])
            ->setName($combinedImportData[$this->customerCsvImporterConfig::BRAND_NAME])
            ->setIsActive($combinedImportData[$this->customerCsvImporterConfig::BRAND_ACTIVE])
            ->setStatus($combinedImportData[$this->customerCsvImporterConfig::BRAND_STATUS])
            ->setStoreName($combinedImportData[$this->customerCsvImporterConfig::BRAND_MARKET]);

        return $companyTransfer;
    }

    /**
     * @param array<string, mixed> $combinedImportData
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    protected function mapCustomerRowToCompanyBusinessUnitTransfer(array $combinedImportData): CompanyBusinessUnitTransfer
    {
        $companyBusinessUnitTransfer = new CompanyBusinessUnitTransfer();

        $companyBusinessUnitTransfer
            ->setKey($combinedImportData[$this->customerCsvImporterConfig::SOLD_TO_ID])
            ->setName($combinedImportData[$this->customerCsvImporterConfig::SOLD_TO_NAME])
            ->setEmail($combinedImportData[$this->customerCsvImporterConfig::EMAIL])
            ->setPhone($combinedImportData[$this->customerCsvImporterConfig::PHONE]);

        if ($combinedImportData[$this->customerCsvImporterConfig::SHIP_TO_ID]) {
            $companyBusinessUnitTransfer
                ->setParentCompanyBusinessUnitKey($combinedImportData[$this->customerCsvImporterConfig::SOLD_TO_ID])
                ->setKey($combinedImportData[$this->customerCsvImporterConfig::SHIP_TO_ID])
                ->setName($combinedImportData[$this->customerCsvImporterConfig::SHIP_TO_NAME]);
        }

        return $companyBusinessUnitTransfer;
    }

    /**
     * @param array<string, mixed> $combinedImportData
     *
     * @return \Generated\Shared\Transfer\CompanyUnitAddressTransfer
     */
    protected function mapCustomerRowToCompanyUnitAddressTransfer(array $combinedImportData): CompanyUnitAddressTransfer
    {
        $companyUnitAddressTransfer = new CompanyUnitAddressTransfer();

        $companyUnitAddressTransfer
            ->setKey($combinedImportData[$this->customerCsvImporterConfig::ADDRESS_ID])
            ->setAddress1($combinedImportData[$this->customerCsvImporterConfig::ADDRESS1])
            ->setAddress2($combinedImportData[$this->customerCsvImporterConfig::ADDRESS2])
            ->setAddress3($combinedImportData[$this->customerCsvImporterConfig::ADDRESS3])
            ->setIso2Code($combinedImportData[$this->customerCsvImporterConfig::COUNTRY_ISO2_CODE])
            ->setState($combinedImportData[$this->customerCsvImporterConfig::STATE])
            ->setCity($combinedImportData[$this->customerCsvImporterConfig::CITY])
            ->setZipCode($combinedImportData[$this->customerCsvImporterConfig::ZIP_CODE])
            ->setPhone($combinedImportData[$this->customerCsvImporterConfig::PHONE]);

        return $companyUnitAddressTransfer;
    }

    /**
     * @param array<string, mixed> $combinedImportData
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    protected function mapCustomerRowToCustomerTransfer(array $combinedImportData): CustomerTransfer
    {
        $customerTransfer = new CustomerTransfer();
        $customerTransfer
            ->setSalutation($combinedImportData[$this->customerCsvImporterConfig::ADMIN_SALUTATION])
            ->setFirstName($combinedImportData[$this->customerCsvImporterConfig::ADMIN_FIRST_NAME])
            ->setLastName($combinedImportData[$this->customerCsvImporterConfig::ADMIN_LAST_NAME])
            ->setEmail($combinedImportData[$this->customerCsvImporterConfig::ADMIN_EMAIL])
            ->setPhone($combinedImportData[$this->customerCsvImporterConfig::ADMIN_PHONE])
            ->setGender($combinedImportData[$this->customerCsvImporterConfig::ADMIN_GENDER]);

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
     * @param \Generated\Shared\Transfer\CustomerResponseTransfer $customerResponseTransfer
     * @param \Generated\Shared\Transfer\CustomerImportTransfer $customerImportTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerResponseTransfer
     */
    public function mapCustomerToCustomerResponse(
        CustomerResponseTransfer $customerResponseTransfer,
        CustomerImportTransfer $customerImportTransfer,
    ): CustomerResponseTransfer {
        return $customerResponseTransfer->setCustomerTransfer($customerImportTransfer->getCustomer());
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
