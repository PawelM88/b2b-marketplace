<?php

declare(strict_types=1);

namespace Pyz\Zed\CompanyUnitAddress\Business\Model;

use Generated\Shared\Transfer\CompanyUnitAddressTransfer;
use Generated\Shared\Transfer\SpyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer;
use Pyz\Zed\CompanyUnitAddress\Persistence\CompanyUnitAddressEntityManagerInterface;
use Spryker\Zed\CompanyUnitAddress\Business\Model\CompanyBusinessUnitAddressReaderInterface;
use Spryker\Zed\CompanyUnitAddress\Business\Model\CompanyUnitAddress as SprykerCompanyUnitAddress;
use Spryker\Zed\CompanyUnitAddress\Business\Model\CompanyUnitAddressPluginExecutorInterface;
use Spryker\Zed\CompanyUnitAddress\Dependency\Facade\CompanyUnitAddressToCompanyBusinessUnitFacadeInterface;
use Spryker\Zed\CompanyUnitAddress\Dependency\Facade\CompanyUnitAddressToCountryFacadeInterface;
use Spryker\Zed\CompanyUnitAddress\Dependency\Facade\CompanyUnitAddressToLocaleFacadeInterface;

class CompanyUnitAddress extends SprykerCompanyUnitAddress implements CompanyUnitAddressInterface
{
    /**
     * @var \Pyz\Zed\CompanyUnitAddress\Persistence\CompanyUnitAddressEntityManagerInterface
     */
    protected $entityManager;

    /**
     * @param \Pyz\Zed\CompanyUnitAddress\Persistence\CompanyUnitAddressEntityManagerInterface $entityManager
     * @param \Spryker\Zed\CompanyUnitAddress\Dependency\Facade\CompanyUnitAddressToCountryFacadeInterface $countryFacade
     * @param \Spryker\Zed\CompanyUnitAddress\Dependency\Facade\CompanyUnitAddressToLocaleFacadeInterface $localeFacade
     * @param \Spryker\Zed\CompanyUnitAddress\Dependency\Facade\CompanyUnitAddressToCompanyBusinessUnitFacadeInterface $companyBusinessUnitFacade
     * @param \Spryker\Zed\CompanyUnitAddress\Business\Model\CompanyBusinessUnitAddressReaderInterface $companyBusinessUnitAddressReader
     * @param \Spryker\Zed\CompanyUnitAddress\Business\Model\CompanyUnitAddressPluginExecutorInterface $companyUnitAddressPluginExecutor
     */
    public function __construct(
        CompanyUnitAddressEntityManagerInterface $entityManager,
        CompanyUnitAddressToCountryFacadeInterface $countryFacade,
        CompanyUnitAddressToLocaleFacadeInterface $localeFacade,
        CompanyUnitAddressToCompanyBusinessUnitFacadeInterface $companyBusinessUnitFacade,
        CompanyBusinessUnitAddressReaderInterface $companyBusinessUnitAddressReader,
        CompanyUnitAddressPluginExecutorInterface $companyUnitAddressPluginExecutor,
    ) {
        parent::__construct(
            $entityManager,
            $countryFacade,
            $localeFacade,
            $companyBusinessUnitFacade,
            $companyBusinessUnitAddressReader,
            $companyUnitAddressPluginExecutor,
        );
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyUnitAddressTransfer $companyUnitAddressTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyUnitAddressTransfer
     */
    public function createCompanyUnitAddressBasedOnDataFromCombinedCsvFile(
        CompanyUnitAddressTransfer $companyUnitAddressTransfer,
    ): CompanyUnitAddressTransfer {
        $idCountry = $this->retrieveIdCountry($companyUnitAddressTransfer);
        $companyUnitAddressTransfer->setFkCountry($idCountry);

        return $this->entityManager->saveCompanyUnitAddressBasedOnDataFromCombinedCsvFile(
            $companyUnitAddressTransfer,
        );
    }

    /**
     * @param \Generated\Shared\Transfer\SpyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer $spyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer
     *
     * @return void
     */
    public function saveAddressToBusinessUnitRelationFromCombinedCsvFile(
        SpyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer $spyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer,
    ): void {
        $this->entityManager->saveAddressToBusinessUnitRelationFromCombinedCsvFile(
            $spyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer,
        );
    }
}
