<?php

declare(strict_types=1);

namespace Pyz\Zed\CompanyBusinessUnit\Business;

use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacade as SprykerCompanyBusinessUnitFacade;

/**
 * @method \Pyz\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitBusinessFactory getFactory()
 * @method \Pyz\Zed\CompanyBusinessUnit\Persistence\CompanyBusinessUnitRepositoryInterface getRepository()
 * @method \Pyz\Zed\CompanyBusinessUnit\Persistence\CompanyBusinessUnitEntityManagerInterface getEntityManager()
 */
class CompanyBusinessUnitFacade extends SprykerCompanyBusinessUnitFacade implements CompanyBusinessUnitFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    public function createCompanyBusinessUnitBasedOnDataFromCombinedCsvFile(
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer,
    ): CompanyBusinessUnitTransfer {
        return $this->getFactory()
            ->createCompanyBusinessUnitCreator()
            ->createCompanyBusinessUnitBasedOnDataFromCombinedCsvFile($companyBusinessUnitTransfer);
    }

    /**
     * @param string $companyBusinessUnitKey
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    public function getCompanyBusinessUnitByKey(string $companyBusinessUnitKey): CompanyBusinessUnitTransfer
    {
        return $this->getRepository()->getCompanyBusinessUnitByKey($companyBusinessUnitKey);
    }
}
