<?php

declare(strict_types=1);

namespace Pyz\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitCreator;

use Generated\Shared\Transfer\CompanyBusinessUnitTransfer;
use Pyz\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface;
use Pyz\Zed\CompanyBusinessUnit\Persistence\CompanyBusinessUnitEntityManagerInterface;
use Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitCreator\CompanyBusinessUnitCreator as SprykerCompanyBusinessUnitCreator;
use Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitPluginExecutor\CompanyBusinessUnitPluginExecutorInterface;
use Spryker\Zed\CompanyBusinessUnit\CompanyBusinessUnitConfig;

class CompanyBusinessUnitCreator extends SprykerCompanyBusinessUnitCreator implements
    CompanyBusinessUnitCreatorInterface
{
    /**
     * @var \Pyz\Zed\CompanyBusinessUnit\Persistence\CompanyBusinessUnitEntityManagerInterface
     */
    protected $companyBusinessUnitEntityManager;

    /**
     * @param \Pyz\Zed\CompanyBusinessUnit\Persistence\CompanyBusinessUnitEntityManagerInterface $companyBusinessUnitEntityManager
     * @param \Spryker\Zed\CompanyBusinessUnit\CompanyBusinessUnitConfig $companyBusinessUnitConfig
     * @param \Spryker\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitPluginExecutor\CompanyBusinessUnitPluginExecutorInterface $pluginExecutor
     * @param \Pyz\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface $companyBusinessUnitFacade
     */
    public function __construct(
        CompanyBusinessUnitEntityManagerInterface $companyBusinessUnitEntityManager,
        CompanyBusinessUnitConfig $companyBusinessUnitConfig,
        CompanyBusinessUnitPluginExecutorInterface $pluginExecutor,
        protected CompanyBusinessUnitFacadeInterface $companyBusinessUnitFacade,
    ) {
        parent::__construct(
            $companyBusinessUnitEntityManager,
            $companyBusinessUnitConfig,
            $pluginExecutor,
        );
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitTransfer $companyBusinessUnitTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitTransfer
     */
    public function createCompanyBusinessUnitBasedOnDataFromCombinedCsvFile(
        CompanyBusinessUnitTransfer $companyBusinessUnitTransfer,
    ): CompanyBusinessUnitTransfer {
        $parentCompanyBusinessUnitKey = $companyBusinessUnitTransfer->getParentCompanyBusinessUnitKey();

        if ($parentCompanyBusinessUnitKey) {
            $companyBusinessUnit = $this->companyBusinessUnitFacade->getCompanyBusinessUnitByKey(
                $parentCompanyBusinessUnitKey,
            );
            $companyBusinessUnitTransfer->setFkParentCompanyBusinessUnit(
                $companyBusinessUnit->getIdCompanyBusinessUnit(),
            );
        }

        return $this->companyBusinessUnitEntityManager->saveCompanyBusinessUnitBasedOnDataFromCombinedCsvFile(
            $companyBusinessUnitTransfer,
        );
    }
}
