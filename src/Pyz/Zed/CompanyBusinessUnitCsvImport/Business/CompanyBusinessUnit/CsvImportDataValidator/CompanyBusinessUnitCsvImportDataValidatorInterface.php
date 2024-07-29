<?php

namespace Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CsvImportDataValidator;

use Generated\Shared\Transfer\CompanyBusinessUnitImportTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitListImportErrorTransfer;

interface CompanyBusinessUnitCsvImportDataValidatorInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitImportTransfer $companyBusinessUnitImportTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitListImportErrorTransfer|null
     */
    public function validateCompanyBusinessUnitImportTransfer(
        CompanyBusinessUnitImportTransfer $companyBusinessUnitImportTransfer,
    ): ?CompanyBusinessUnitListImportErrorTransfer;
}
