<?php

namespace Pyz\Zed\Company\Business;

use Generated\Shared\Transfer\CompanyTransfer;
use Spryker\Zed\Company\Business\CompanyFacadeInterface as SprykerCompanyFacadeInterface;

interface CompanyFacadeInterface extends SprykerCompanyFacadeInterface
{
    /**
     * Specification:
     *  - Creates a new company and predefined roles for it
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer
     */
    public function createCompanyBasedOnDataFromCombinedCsvFile(CompanyTransfer $companyTransfer): CompanyTransfer;
}
