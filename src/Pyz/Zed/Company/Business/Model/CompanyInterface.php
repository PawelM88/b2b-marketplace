<?php

namespace Pyz\Zed\Company\Business\Model;

use Generated\Shared\Transfer\CompanyTransfer;
use Spryker\Zed\Company\Business\Model\CompanyInterface as SprykerCompanyInterface;

interface CompanyInterface extends SprykerCompanyInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer
     */
    public function createCompanyBasedOnDataFromCombinedCsvFile(CompanyTransfer $companyTransfer): CompanyTransfer;
}
