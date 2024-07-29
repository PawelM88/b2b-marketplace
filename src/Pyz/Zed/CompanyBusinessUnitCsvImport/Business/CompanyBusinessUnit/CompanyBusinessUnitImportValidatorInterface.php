<?php

namespace Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit;

use Generated\Shared\Transfer\CompanyBusinessUnitListImportRequestTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitListImportResponseTransfer;

interface CompanyBusinessUnitImportValidatorInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitListImportRequestTransfer $companyBusinessUnitListImportRequestTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitListImportResponseTransfer
     */
    public function validateCompanyBusinessUnitCsvData(
        CompanyBusinessUnitListImportRequestTransfer $companyBusinessUnitListImportRequestTransfer,
    ): CompanyBusinessUnitListImportResponseTransfer;
}
