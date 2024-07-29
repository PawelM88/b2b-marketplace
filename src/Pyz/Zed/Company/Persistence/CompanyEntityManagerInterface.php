<?php

namespace Pyz\Zed\Company\Persistence;

use Generated\Shared\Transfer\CompanyTransfer;
use Spryker\Zed\Company\Persistence\CompanyEntityManagerInterface as SprykerCompanyEntityManagerInterface;

interface CompanyEntityManagerInterface extends SprykerCompanyEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer
     */
    public function saveCompanyBasedOnDataFromCombinedCsvFile(CompanyTransfer $companyTransfer): CompanyTransfer;
}
