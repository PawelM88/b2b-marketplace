<?php

declare(strict_types=1);

namespace Pyz\Zed\Company\Business\Model;

use Generated\Shared\Transfer\CompanyResponseTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Pyz\Zed\Company\Persistence\CompanyEntityManagerInterface;
use Spryker\Zed\Company\Business\Model\Company as SprykerCompany;
use Spryker\Zed\Company\Business\Model\CompanyPluginExecutorInterface;
use Spryker\Zed\Company\Business\Model\CompanyStoreRelationWriterInterface;
use Spryker\Zed\Company\Persistence\CompanyRepositoryInterface;
use Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface;

class Company extends SprykerCompany implements CompanyInterface
{
    /**
     * @var \Pyz\Zed\Company\Persistence\CompanyEntityManagerInterface
     */
    protected $companyEntityManager;

    /**
     * @param \Spryker\Zed\Company\Persistence\CompanyRepositoryInterface $companyRepository
     * @param \Pyz\Zed\Company\Persistence\CompanyEntityManagerInterface $companyEntityManager
     * @param \Spryker\Zed\Company\Business\Model\CompanyPluginExecutorInterface $companyPluginExecutor
     * @param \Spryker\Zed\Company\Business\Model\CompanyStoreRelationWriterInterface $companyStoreRelationWriter
     * @param \Spryker\Zed\CompanyRole\Business\CompanyRoleFacadeInterface $companyRoleFacade
     */
    public function __construct(
        CompanyRepositoryInterface $companyRepository,
        CompanyEntityManagerInterface $companyEntityManager,
        CompanyPluginExecutorInterface $companyPluginExecutor,
        CompanyStoreRelationWriterInterface $companyStoreRelationWriter,
        protected CompanyRoleFacadeInterface $companyRoleFacade,
    ) {
        parent::__construct(
            $companyRepository,
            $companyEntityManager,
            $companyPluginExecutor,
            $companyStoreRelationWriter,
        );
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer
     */
    public function createCompanyBasedOnDataFromCombinedCsvFile(CompanyTransfer $companyTransfer): CompanyTransfer
    {
        $savedCompany = $this->executeSaveCompanyBasedOnDataFromCombinedCsvFile($companyTransfer);

        if ($savedCompany->getIsNew() === true) {
            $companyResponseTransfer = new CompanyResponseTransfer();
            $companyResponseTransfer->setCompanyTransfer($savedCompany);

            $this->companyRoleFacade->createByCompany($companyResponseTransfer);
        }

        return $savedCompany;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer
     */
    protected function executeSaveCompanyBasedOnDataFromCombinedCsvFile(CompanyTransfer $companyTransfer): CompanyTransfer
    {
        $savedCompany = $this->companyEntityManager->saveCompanyBasedOnDataFromCombinedCsvFile($companyTransfer);
        $this->persistStoreRelations($savedCompany);

        return $savedCompany;
    }
}
