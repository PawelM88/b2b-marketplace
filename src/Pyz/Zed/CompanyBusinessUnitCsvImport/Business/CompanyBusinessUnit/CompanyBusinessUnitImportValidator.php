<?php

declare(strict_types=1);

namespace Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit;

use Generated\Shared\Transfer\CompanyBusinessUnitListImportRequestTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitListImportResponseTransfer;

class CompanyBusinessUnitImportValidator implements CompanyBusinessUnitImportValidatorInterface
{
    /**
     * @param \Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CompanyBusinessUnitImportDataValidatorInterface $companyBusinessUnitImportDataValidator
     */
    public function __construct(protected CompanyBusinessUnitImportDataValidatorInterface $companyBusinessUnitImportDataValidator)
    {
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitListImportRequestTransfer $companyBusinessUnitListImportRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitListImportResponseTransfer
     */
    public function validateCompanyBusinessUnitCsvData(
        CompanyBusinessUnitListImportRequestTransfer $companyBusinessUnitListImportRequestTransfer,
    ): CompanyBusinessUnitListImportResponseTransfer {
        $companyBusinessUnitListImportResponseTransfer = new CompanyBusinessUnitListImportResponseTransfer();

        foreach ($companyBusinessUnitListImportRequestTransfer->getItems() as $companyBusinessUnitImportTransfer) {
            $companyBusinessUnitListImportError = $this->companyBusinessUnitImportDataValidator->validateCompanyBusinessUnitImportTransfer(
                $companyBusinessUnitImportTransfer,
            );

            if ($companyBusinessUnitListImportError !== null) {
                $companyBusinessUnitListImportResponseTransfer->addError($companyBusinessUnitListImportError);

                continue;
            }

            $companyBusinessUnitListImportResponseTransfer->setIsSuccess(true);
        }

        $companyBusinessUnitListImportResponseTransfer->setCompanyBusinessUnitListImportRequest($companyBusinessUnitListImportRequestTransfer);

        return $companyBusinessUnitListImportResponseTransfer;
    }
}
