<?php

declare(strict_types=1);

namespace Pyz\Zed\Customer\Communication;

use Generated\Shared\Transfer\CustomerListImportResponseTransfer;
use Pyz\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface;
use Pyz\Zed\CompanyUnitAddress\Business\CompanyUnitAddressFacadeInterface;
use Pyz\Zed\Customer\Business\CustomerFacadeInterface;
use Pyz\Zed\Customer\Communication\Form\CustomerImportForm;
use Pyz\Zed\Customer\Communication\Table\Formatter\TableFormatter;
use Pyz\Zed\Customer\Communication\Table\Formatter\TableFormatterInterface;
use Pyz\Zed\Customer\Communication\Table\ImportErrorListTable;
use Pyz\Zed\Customer\CustomerDependencyProvider;
use Pyz\Zed\CustomerCsvImport\Business\CustomerCsvImportFacadeInterface;
use Spryker\Zed\Company\Business\CompanyFacadeInterface;
use Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface;
use Spryker\Zed\Customer\Communication\CustomerCommunicationFactory as SprykerCommunicationFactory;
use Spryker\Zed\Translator\Business\TranslatorFacadeInterface;
use Symfony\Component\Form\FormInterface;

/**
 * @method \Pyz\Zed\Customer\Persistence\CustomerRepositoryInterface getRepository()
 * @method \Pyz\Zed\Customer\Business\CustomerFacadeInterface getFacade()
 * @method \Spryker\Zed\Customer\Persistence\CustomerEntityManagerInterface getEntityManager()
 * @method \Pyz\Zed\Customer\CustomerConfig getConfig()
 */
class CustomerCommunicationFactory extends SprykerCommunicationFactory
{
    /**
     * @param array<string, mixed> $options
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getCustomerImportForm(array $options = []): FormInterface
    {
        return $this
            ->getFormFactory()
            ->create(
                CustomerImportForm::class,
                [],
                $options,
            );
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerListImportResponseTransfer $customerListImportResponseTransfer
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Zed\Customer\Communication\Table\ImportErrorListTable
     */
    public function createImportErrorTable(CustomerListImportResponseTransfer $customerListImportResponseTransfer): ImportErrorListTable
    {
        return new ImportErrorListTable(
            $customerListImportResponseTransfer,
            $this->getTranslatorFacade(),
        );
    }

    /**
     * @return \Pyz\Zed\Customer\Communication\Table\Formatter\TableFormatterInterface
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
    public function getCompanyFacade(): CompanyFacadeInterface
    {
        return $this->getProvidedDependency(CustomerDependencyProvider::COMPANY_FACADE);
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Zed\CompanyBusinessUnit\Business\CompanyBusinessUnitFacadeInterface
     */
    public function getCompanyBusinessUnitFacade(): CompanyBusinessUnitFacadeInterface
    {
        return $this->getProvidedDependency(CustomerDependencyProvider::COMPANY_BUSINESS_UNIT_FACADE);
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Zed\CustomerCsvImport\Business\CustomerCsvImportFacadeInterface
     */
    public function getCustomerCsvImporterFacade(): CustomerCsvImportFacadeInterface
    {
        return $this->getProvidedDependency(CustomerDependencyProvider::CUSTOMER_CSV_IMPORTER_FACADE);
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Zed\CompanyUnitAddress\Business\CompanyUnitAddressFacadeInterface
     */
    public function getCompanyUnitAddressFacade(): CompanyUnitAddressFacadeInterface
    {
        return $this->getProvidedDependency(CustomerDependencyProvider::COMPANY_UNIT_ADDRESS_FACADE);
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Spryker\Zed\Translator\Business\TranslatorFacadeInterface
     */
    public function getTranslatorFacade(): TranslatorFacadeInterface
    {
        return $this->getProvidedDependency(CustomerDependencyProvider::TRANSLATOR_FACADE);
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Zed\Customer\Business\CustomerFacadeInterface
     */
    public function getCustomerFacade(): CustomerFacadeInterface
    {
        return $this->getProvidedDependency(CustomerDependencyProvider::CUSTOMER_FACADE);
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Spryker\Zed\CompanyUser\Business\CompanyUserFacadeInterface
     */
    public function getCompanyUserFacade(): CompanyUserFacadeInterface
    {
        return $this->getProvidedDependency(CustomerDependencyProvider::COMPANY_USER_FACADE);
    }
}
