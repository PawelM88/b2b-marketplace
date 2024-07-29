<?php

declare(strict_types=1);

namespace Pyz\Zed\CompanyBusinessUnitCsvImport\Business;

use Generated\Shared\Transfer\CompanyBusinessUnitCsvValidationResultTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitListImportRequestTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitListImportResponseTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CompanyUnitAddressTransfer;
use Generated\Shared\Transfer\CompanyUserTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\SpyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer;
use Pyz\Zed\CompanyBusinessUnitGui\Communication\File\UploadedFile;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnitCsvImportBusinessFactory getFactory()
 */
class CompanyBusinessUnitCsvImportFacade extends AbstractFacade implements CompanyBusinessUnitCsvImportFacadeInterface
{
    /**
     * @param \Pyz\Zed\CompanyBusinessUnitGui\Communication\File\UploadedFile $uploadedFile
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitCsvValidationResultTransfer
     */
    public function validateCsvFile(UploadedFile $uploadedFile): CompanyBusinessUnitCsvValidationResultTransfer
    {
        return $this->getFactory()->createCompanyBusinessUnitImportCsvHeadersValidator()->validateCsvFile($uploadedFile);
    }

    /**
     * @param \Pyz\Zed\CompanyBusinessUnitGui\Communication\File\UploadedFile $uploadedFile
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitListImportRequestTransfer $companyBusinessUnitListImportRequestTransfer
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitListImportRequestTransfer
     */
    public function readCompanyBusinessUnitImportTransfersFromCsvFile(
        UploadedFile $uploadedFile,
        CompanyBusinessUnitListImportRequestTransfer $companyBusinessUnitListImportRequestTransfer,
    ): CompanyBusinessUnitListImportRequestTransfer {
        return $this->getFactory()->createCompanyBusinessUnitCsvImportReader()->readCompanyBusinessUnitImportTransfersFromCsvFile(
            $uploadedFile,
            $companyBusinessUnitListImportRequestTransfer,
        );
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitListImportRequestTransfer $companyBusinessUnitListImportRequestTransfer
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitListImportResponseTransfer
     */
    public function validateCompanyBusinessUnitCsvData(
        CompanyBusinessUnitListImportRequestTransfer $companyBusinessUnitListImportRequestTransfer,
    ): CompanyBusinessUnitListImportResponseTransfer {
        return $this->getFactory()
            ->createCompanyBusinessUnitImportValidator()
            ->validateCompanyBusinessUnitCsvData($companyBusinessUnitListImportRequestTransfer);
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
        return $this->getFactory()->createCompanyBusinessUnitCsvImportMapper()->mapCompanyToCompanyBusinessUnit(
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
        return $this->getFactory()->createCompanyBusinessUnitCsvImportMapper()->mapCompanyToCompanyUnitAddress(
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
        return $this->getFactory()->createCompanyBusinessUnitCsvImportMapper(
        )->mapCompanyBusinessUnitAndCompanyUnitAddressToCompanyBusinessUnitAddress(
            $companyBusinessUnitTransfer,
            $companyUnitAddressTransfer,
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
        return $this->getFactory()->createCompanyBusinessUnitCsvImportMapper()->mapCustomerAndCompanyDataToCompanyUser(
            $customerTransfer,
            $companyTransfer,
            $companyBusinessUnitTransfer,
        );
    }
}
