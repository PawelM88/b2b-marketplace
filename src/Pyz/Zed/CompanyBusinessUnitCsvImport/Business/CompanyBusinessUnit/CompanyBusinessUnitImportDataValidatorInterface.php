<?php

namespace Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit;

use Generated\Shared\Transfer\CompanyBusinessUnitImportTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitListImportErrorTransfer;

interface CompanyBusinessUnitImportDataValidatorInterface
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
