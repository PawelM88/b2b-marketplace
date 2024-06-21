<?php

declare(strict_types=1);

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
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pyz\Zed\CustomerCsvImport\Business\CustomerCsvImportBusinessFactory getFactory()
 */
class CustomerCsvImportFacade extends AbstractFacade implements CustomerCsvImportFacadeInterface
{
    /**
     * @param \Pyz\Zed\Customer\Communication\File\UploadedFile $uploadedFile
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Generated\Shared\Transfer\CustomerCsvValidationResultTransfer
     */
    public function validateCsvFile(UploadedFile $uploadedFile): CustomerCsvValidationResultTransfer
    {
        return $this->getFactory()->createCustomerImportCsvHeadersValidator()->validateCsvFile($uploadedFile);
    }

    /**
     * @param \Pyz\Zed\Customer\Communication\File\UploadedFile $uploadedFile
     * @param \Generated\Shared\Transfer\CustomerListImportRequestTransfer $customerListImportRequestTransfer
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Generated\Shared\Transfer\CustomerListImportRequestTransfer
     */
    public function readCustomerImportTransfersFromCsvFile(
        UploadedFile $uploadedFile,
        CustomerListImportRequestTransfer $customerListImportRequestTransfer,
    ): CustomerListImportRequestTransfer {
        return $this->getFactory()->createCustomerCsvImportReader()->readCustomerImportTransfersFromCsvFile(
            $uploadedFile,
            $customerListImportRequestTransfer,
        );
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerListImportRequestTransfer $customerListImportRequestTransfer
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Generated\Shared\Transfer\CustomerListImportResponseTransfer
     */
    public function validateCustomerCsvData(CustomerListImportRequestTransfer $customerListImportRequestTransfer): CustomerListImportResponseTransfer
    {
        return $this->getFactory()
            ->createCustomerImportValidator()
            ->validateCustomerCsvData($customerListImportRequestTransfer);
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
        return $this->getFactory()->createCustomerCsvImportMapper()->mapCompanyToCompanyBusinessUnit(
            $companyTransfer,
            $companyBusinessUnitTransfer,
        );
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
        return $this->getFactory()->createCustomerCsvImportMapper()->mapCompanyToCompanyUnitAddress(
            $companyTransfer,
            $companyUnitAddressTransfer,
        );
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
        return $this->getFactory()->createCustomerCsvImportMapper(
        )->mapCompanyBusinessUnitAndCompanyUnitAddressToCompanyBusinessUnitAddress(
            $companyBusinessUnitTransfer,
            $companyUnitAddressTransfer,
        );
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerResponseTransfer $customerResponseTransfer
     * @param \Generated\Shared\Transfer\CustomerImportTransfer $customerImportTransfer
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Generated\Shared\Transfer\CustomerResponseTransfer
     */
    public function mapCustomerToCustomerResponse(
        CustomerResponseTransfer $customerResponseTransfer,
        CustomerImportTransfer $customerImportTransfer,
    ): CustomerResponseTransfer {
        return $this->getFactory()->createCustomerCsvImportMapper()->mapCustomerToCustomerResponse(
            $customerResponseTransfer,
            $customerImportTransfer,
        );
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
        return $this->getFactory()->createCustomerCsvImportMapper()->mapCustomerAndCompanyDataToCompanyUser(
            $customerTransfer,
            $companyTransfer,
            $companyBusinessUnitTransfer,
        );
    }
}
