<?php

namespace Pyz\Zed\CustomerCsvImport\Business;

use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyUnitAddressTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerCsvValidationResultTransfer;
use Generated\Shared\Transfer\CustomerImportTransfer;
use Generated\Shared\Transfer\CustomerListImportRequestTransfer;
use Generated\Shared\Transfer\CustomerListImportResponseTransfer;
use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\SpyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer;
use Pyz\Zed\Customer\Communication\File\UploadedFile;

interface CustomerCsvImportFacadeInterface
{
    /**
     * Specification:
     *  - Extracts the headers from the csv file and then checks them to see if they match those in the Config file
     *
     * @api
     *
     * @param \Pyz\Zed\Customer\Communication\File\UploadedFile $uploadedFile
     *
     * @return \Generated\Shared\Transfer\CustomerCsvValidationResultTransfer
     */
    public function validateCsvFile(UploadedFile $uploadedFile): CustomerCsvValidationResultTransfer;

    /**
     * Specification:
     *  - Reads data from a csv file and maps it to the appropriate transfers
     *
     * @api
     *
     * @param \Pyz\Zed\Customer\Communication\File\UploadedFile $uploadedFile
     * @param \Generated\Shared\Transfer\CustomerListImportRequestTransfer $customerListImportRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerListImportRequestTransfer
     */
    public function readCustomerImportTransfersFromCsvFile(
        UploadedFile $uploadedFile,
        CustomerListImportRequestTransfer $customerListImportRequestTransfer,
    ): CustomerListImportRequestTransfer;

    /**
     * Specification:
     *  - Validates previously mapped data from a csv file
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerListImportRequestTransfer $customerListImportRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerListImportResponseTransfer
     */
    public function validateCustomerCsvData(CustomerListImportRequestTransfer $customerListImportRequestTransfer): CustomerListImportResponseTransfer;

    /**
     * Specification:
     *  - Maps idCompany from CompanyTransfer to fkCompany in CompanyBusinessUnitTransfer
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    public function mapCompanyToCompanyBusinessUnit(
        CompanyTransfer $companyTransfer,
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer,
    ): CompanyBusinessUnitTransfer;

    /**
     * Specification:
     *  - Maps idCompany from CompanyTransfer to fkCompany in CompanyUnitAddressTransfer
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     * @param \Generated\Shared\Transfer\CompanyUnitAddressTransfer $companyUnitAddressTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUnitAddressTransfer
     */
    public function mapCompanyToCompanyUnitAddress(
        CompanyTransfer $companyTransfer,
        CompanyUnitAddressTransfer $companyUnitAddressTransfer,
    ): CompanyUnitAddressTransfer;

    /**
     * Specification:
     *  - Maps idCompanyBusinessUnit from CompanyBusinessUnitTransfer to fkCompanyBusinessUnit in SpyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer
     *  - Maps idCompanyUnitAddress from CompanyUnitAddressTransfer to fkCompanyUnitAddress in SpyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
     * @param \Generated\Shared\Transfer\CompanyUnitAddressTransfer $companyUnitAddressTransfer
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Generated\Shared\Transfer\SpyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer
     */
    public function mapCompanyBusinessUnitAndCompanyUnitAddressToCompanyBusinessUnitAddress(
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer,
        CompanyUnitAddressTransfer $companyUnitAddressTransfer,
    ): SpyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer;

    /**
     * Specification:
     *  - Maps CustomerTransfer from CustomerImportTransfer to CustomerResponseTransfer
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerResponseTransfer $customerResponseTransfer
     * @param \Generated\Shared\Transfer\CustomerImportTransfer $customerImportTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerResponseTransfer
     */
    public function mapCustomerToCustomerResponse(
        CustomerResponseTransfer $customerResponseTransfer,
        CustomerImportTransfer $customerImportTransfer,
    ): CustomerResponseTransfer;

    /**
     * Specification:
     *  - Maps idCompany from CompanyTransfer to fkCompany in CompanyUserTransfer
     *  - Maps idCustomer from CompanyTransfer to fkCustomer in CompanyUserTransfer
     *  - Maps CompanyTransfer to CompanyUserTransfer
     *  - Maps CustomerTransfer to CompanyUserTransfer
     *  - Maps idCompanyBusinessUnit from CompanyBusinessUnitTransfer to fkCompanyBusinessUnit in CompanyUserTransfer
     *
     * @api
     *
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
    ): CompanyUserTransfer;
}
