<?php

declare(strict_types=1);

namespace Pyz\Zed\CustomerCsvImport\Business;

use Pyz\Zed\CustomerCsvImport\Business\Customer\CsvImportDataValidator\CompanyBusinessUnitCsvDataValidator;
use Pyz\Zed\CustomerCsvImport\Business\Customer\CsvImportDataValidator\CompanyCsvDataValidator;
use Pyz\Zed\CustomerCsvImport\Business\Customer\CsvImportDataValidator\CompanyUnitAddressCsvDataValidator;
use Pyz\Zed\CustomerCsvImport\Business\Customer\CsvImportDataValidator\CustomerCsvDataValidator;
use Pyz\Zed\CustomerCsvImport\Business\Customer\CsvImportDataValidator\CustomerCsvImportDataValidatorInterface;
use Pyz\Zed\CustomerCsvImport\Business\Customer\CustomerCsvImportHeadersValidator;
use Pyz\Zed\CustomerCsvImport\Business\Customer\CustomerCsvImportHeadersValidatorInterface;
use Pyz\Zed\CustomerCsvImport\Business\Customer\CustomerCsvImportMapper;
use Pyz\Zed\CustomerCsvImport\Business\Customer\CustomerCsvImportMapperInterface;
use Pyz\Zed\CustomerCsvImport\Business\Customer\CustomerCsvImportReader;
use Pyz\Zed\CustomerCsvImport\Business\Customer\CustomerCsvImportReaderInterface;
use Pyz\Zed\CustomerCsvImport\Business\Customer\CustomerImportDataValidator;
use Pyz\Zed\CustomerCsvImport\Business\Customer\CustomerImportDataValidatorInterface;
use Pyz\Zed\CustomerCsvImport\Business\Customer\CustomerImportValidator;
use Pyz\Zed\CustomerCsvImport\Business\Customer\CustomerImportValidatorInterface;
use Pyz\Zed\CustomerCsvImport\CustomerCsvImportDependencyProvider;
use Spryker\Service\UtilCsv\UtilCsvServiceInterface;
use Spryker\Zed\Country\Business\CountryFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\Store\Business\StoreFacadeInterface;

/**
 * @method \Pyz\Zed\CustomerCsvImport\CustomerCsvImportConfig getConfig()
 */
class CustomerCsvImportBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Zed\CustomerCsvImport\Business\Customer\CustomerCsvImportHeadersValidatorInterface
     */
    public function createCustomerImportCsvHeadersValidator(): CustomerCsvImportHeadersValidatorInterface
    {
        return new CustomerCsvImportHeadersValidator(
            $this->getUtilCsvService(),
            $this->getConfig(),
        );
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Zed\CustomerCsvImport\Business\Customer\CustomerCsvImportReaderInterface
     */
    public function createCustomerCsvImportReader(): CustomerCsvImportReaderInterface
    {
        return new CustomerCsvImportReader(
            $this->getUtilCsvService(),
            $this->createCustomerCsvImportMapper(),
            $this->getStoreFacade(),
        );
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Spryker\Service\UtilCsv\UtilCsvServiceInterface
     */
    public function getUtilCsvService(): UtilCsvServiceInterface
    {
        return $this->getProvidedDependency(CustomerCsvImportDependencyProvider::SERVICE_UTIL_CSV);
    }

    /**
     * @return \Pyz\Zed\CustomerCsvImport\Business\Customer\CustomerCsvImportMapperInterface
     */
    public function createCustomerCsvImportMapper(): CustomerCsvImportMapperInterface
    {
        return new CustomerCsvImportMapper(
            $this->getConfig(),
        );
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Zed\CustomerCsvImport\Business\Customer\CustomerImportValidatorInterface
     */
    public function createCustomerImportValidator(): CustomerImportValidatorInterface
    {
        return new CustomerImportValidator(
            $this->createCustomerImportDataValidator(),
        );
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Zed\CustomerCsvImport\Business\Customer\CustomerImportDataValidatorInterface
     */
    protected function createCustomerImportDataValidator(): CustomerImportDataValidatorInterface
    {
        return new CustomerImportDataValidator(
            $this->createCustomerImportDataValidatorList(),
        );
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return array<\Pyz\Zed\CustomerCsvImport\Business\Customer\CsvImportDataValidator\CustomerCsvImportDataValidatorInterface>
     */
    protected function createCustomerImportDataValidatorList(): array
    {
        return [
            $this->createCompanyCsvDataValidator(),
            $this->createCompanyBusinessUnitCsvDataValidator(),
            $this->createCompanyUnitAddressCsvDataValidator(),
            $this->createCustomerCsvDataValidator(),
        ];
    }

    /**
     * @return \Pyz\Zed\CustomerCsvImport\Business\Customer\CsvImportDataValidator\CustomerCsvImportDataValidatorInterface
     */
    protected function createCompanyCsvDataValidator(): CustomerCsvImportDataValidatorInterface
    {
        return new CompanyCsvDataValidator();
    }

    /**
     * @return \Pyz\Zed\CustomerCsvImport\Business\Customer\CsvImportDataValidator\CustomerCsvImportDataValidatorInterface
     */
    protected function createCompanyBusinessUnitCsvDataValidator(): CustomerCsvImportDataValidatorInterface
    {
        return new CompanyBusinessUnitCsvDataValidator();
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Zed\CustomerCsvImport\Business\Customer\CsvImportDataValidator\CustomerCsvImportDataValidatorInterface
     */
    protected function createCompanyUnitAddressCsvDataValidator(): CustomerCsvImportDataValidatorInterface
    {
        return new CompanyUnitAddressCsvDataValidator($this->getCountryFacade());
    }

    /**
     * @return \Pyz\Zed\CustomerCsvImport\Business\Customer\CsvImportDataValidator\CustomerCsvImportDataValidatorInterface
     */
    protected function createCustomerCsvDataValidator(): CustomerCsvImportDataValidatorInterface
    {
        return new CustomerCsvDataValidator();
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Spryker\Zed\Store\Business\StoreFacadeInterface
     */
    protected function getStoreFacade(): StoreFacadeInterface
    {
        return $this->getProvidedDependency(CustomerCsvImportDependencyProvider::FACADE_STORE);
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Spryker\Zed\Country\Business\CountryFacadeInterface
     */
    protected function getCountryFacade(): CountryFacadeInterface
    {
        return $this->getProvidedDependency(CustomerCsvImportDependencyProvider::FACADE_COUNTRY);
    }
}
