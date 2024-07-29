<?php

declare(strict_types=1);

namespace Pyz\Zed\Company\Business;

use Generated\Shared\Transfer\CompanyTransfer;
use Spryker\Zed\Company\Business\CompanyFacade as SprykerCompanyFacade;

/**
 * @method \Pyz\Zed\Company\Business\CompanyBusinessFactory getFactory()
 * @method \Spryker\Zed\Company\Persistence\CompanyRepositoryInterface getRepository()
 * @method \Pyz\Zed\Company\Persistence\CompanyEntityManagerInterface getEntityManager()
 */
class CompanyFacade extends SprykerCompanyFacade implements CompanyFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer
     */
    public function createCompanyBasedOnDataFromCombinedCsvFile(CompanyTransfer $companyTransfer): CompanyTransfer
    {
        return $this->getFactory()->createCompany()->createCompanyBasedOnDataFromCombinedCsvFile($companyTransfer);
    }
}
