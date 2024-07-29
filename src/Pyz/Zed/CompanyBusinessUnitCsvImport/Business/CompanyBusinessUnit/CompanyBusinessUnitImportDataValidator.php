<?php

declare(strict_types=1);

namespace Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit;

use Generated\Shared\Transfer\CompanyBusinessUnitImportTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitListImportErrorTransfer;

class CompanyBusinessUnitImportDataValidator implements CompanyBusinessUnitImportDataValidatorInterface
{
 /**
  * @param array<\Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CsvImportDataValidator\CompanyBusinessUnitCsvImportDataValidatorInterface> $dataValidatorList
  */
    public function __construct(protected array $dataValidatorList = [])
    {
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitImportTransfer $companyBusinessUnitImportTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitListImportErrorTransfer|null
     */
    public function validateCompanyBusinessUnitImportTransfer(
        CompanyBusinessUnitImportTransfer $companyBusinessUnitImportTransfer,
    ): ?CompanyBusinessUnitListImportErrorTransfer {
        foreach ($this->dataValidatorList as $dataValidator) {
            $companyBusinessUnitImportError = $dataValidator->validateCompanyBusinessUnitImportTransfer($companyBusinessUnitImportTransfer);

            if ($companyBusinessUnitImportError !== null) {
                return $companyBusinessUnitImportError;
            }
        }

        return null;
    }
}
