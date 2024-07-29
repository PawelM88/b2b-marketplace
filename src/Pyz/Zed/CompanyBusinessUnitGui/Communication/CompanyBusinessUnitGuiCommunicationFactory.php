<?php

declare(strict_types=1);

namespace Pyz\Zed\CompanyBusinessUnitGui\Communication;

use Generated\Shared\Transfer\CompanyBusinessUnitListImportResponseTransfer;
use Pyz\Zed\Company\Business\CompanyFacadeInterface;
use Pyz\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface;
use Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnitCsvImportFacadeInterface;
use Pyz\Zed\CompanyBusinessUnitGui\Communication\Form\CompanyBusinessUnitImportForm;
use Pyz\Zed\CompanyBusinessUnitGui\Communication\Table\Formatter\TableFormatter;
use Pyz\Zed\CompanyBusinessUnitGui\Communication\Table\Formatter\TableFormatterInterface;
use Pyz\Zed\CompanyBusinessUnitGui\Communication\Table\ImportErrorListTable;
use Pyz\Zed\CompanyBusinessUnitGui\CompanyBusinessUnitGuiDependencyProvider;
use Pyz\Zed\CompanyUnitAddress\Business\CompanyUnitAddressFacadeInterface;
use Pyz\Zed\Customer\Business\CustomerFacadeInterface;
use Spryker\Zed\CompanyBusinessUnitGui\Communication\CompanyBusinessUnitGuiCommunicationFactory as SprykerCompanyBusinessUnitGuiCommunicationFactory;
use Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface;
use Spryker\Zed\Translator\Business\TranslatorFacadeInterface;
use Symfony\Component\Form\FormInterface;

/**
 * @method \Spryker\Zed\CompanyBusinessUnitGui\Business\CompanyBusinessUnitGuiFacadeInterface getFacade()
 * @method \Pyz\Zed\CompanyBusinessUnitGui\CompanyBusinessUnitGuiConfig getConfig()
 */
class CompanyBusinessUnitGuiCommunicationFactory extends SprykerCompanyBusinessUnitGuiCommunicationFactory
{
    /**
     * @param array<string, mixed> $options
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getCompanyBusinessUnitImportForm(array $options = []): FormInterface
    {
        return $this
            ->getFormFactory()
            ->create(
                CompanyBusinessUnitImportForm::class,
                [],
                $options,
            );
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitListImportResponseTransfer $companyBusinessUnitListImportResponseTransfer
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Zed\CompanyBusinessUnitGui\Communication\Table\ImportErrorListTable
     */
    public function createImportErrorTable(CompanyBusinessUnitListImportResponseTransfer $companyBusinessUnitListImportResponseTransfer): ImportErrorListTable
    {
        return new ImportErrorListTable(
            $companyBusinessUnitListImportResponseTransfer,
            $this->getTranslatorFacade(),
        );
    }

    /**
     * @return \Pyz\Zed\CompanyBusinessUnitGui\Communication\Table\Formatter\TableFormatterInterface
     */
    public function createTableFormatter(): TableFormatterInterface
    {
        return new TableFormatter();
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Zed\Company\Business\CompanyFacadeInterface
     */
    public function getPyzCompanyFacade(): CompanyFacadeInterface
    {
        return $this->getProvidedDependency(CompanyBusinessUnitGuiDependencyProvider::PYZ_COMPANY_FACADE);
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface
     */
    public function getPyzCompanyBusinessUnitFacade(): CompanyBusinessUnitFacadeInterface
    {
        return $this->getProvidedDependency(CompanyBusinessUnitGuiDependencyProvider::PYZ_COMPANY_BUSINESS_UNIT_FACADE);
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnitCsvImportFacadeInterface
     */
    public function getCompanyBusinessUnitCsvImporterFacade(): CompanyBusinessUnitCsvImportFacadeInterface
    {
        return $this->getProvidedDependency(CompanyBusinessUnitGuiDependencyProvider::COMPANY_BUSINESS_UNIT_CSV_IMPORTER_FACADE);
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Zed\CompanyUnitAddress\Business\CompanyUnitAddressFacadeInterface
     */
    public function getCompanyUnitAddressFacade(): CompanyUnitAddressFacadeInterface
    {
        return $this->getProvidedDependency(CompanyBusinessUnitGuiDependencyProvider::COMPANY_UNIT_ADDRESS_FACADE);
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Spryker\Zed\Translator\Business\TranslatorFacadeInterface
     */
    public function getTranslatorFacade(): TranslatorFacadeInterface
    {
        return $this->getProvidedDependency(CompanyBusinessUnitGuiDependencyProvider::TRANSLATOR_FACADE);
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Zed\Customer\Business\CustomerFacadeInterface
     */
    public function getCustomerFacade(): CustomerFacadeInterface
    {
        return $this->getProvidedDependency(CompanyBusinessUnitGuiDependencyProvider::CUSTOMER_FACADE);
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface
     */
    public function getCompanyUserFacade(): CompanyUserFacadeInterface
    {
        return $this->getProvidedDependency(CompanyBusinessUnitGuiDependencyProvider::COMPANY_USER_FACADE);
    }
}
