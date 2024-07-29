<?php

declare(strict_types=1);

namespace Pyz\Zed\CompanyBusinessUnitCsvImport\Business;

use Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CompanyBusinessUnitCsvImportHeadersValidator;
use Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CompanyBusinessUnitCsvImportHeadersValidatorInterface;
use Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CompanyBusinessUnitCsvImportMapper;
use Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CompanyBusinessUnitCsvImportMapperInterface;
use Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CompanyBusinessUnitCsvImportReader;
use Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CompanyBusinessUnitCsvImportReaderInterface;
use Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CompanyBusinessUnitImportDataValidator;
use Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CompanyBusinessUnitImportDataValidatorInterface;
use Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CompanyBusinessUnitImportValidator;
use Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CompanyBusinessUnitImportValidatorInterface;
use Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CsvImportDataValidator\CompanyBusinessUnitCsvDataValidator;
use Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CsvImportDataValidator\CompanyBusinessUnitCsvImportDataValidatorInterface;
use Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CsvImportDataValidator\CompanyCsvDataValidator;
use Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CsvImportDataValidator\CompanyUnitAddressCsvDataValidator;
use Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CsvImportDataValidator\CustomerCsvDataValidator;
use Pyz\Zed\CompanyBusinessUnitCsvImport\CompanyBusinessUnitCsvImportDependencyProvider;
use Spryker\Service\UtilCsv\UtilCsvServiceInterface;
use Spryker\Zed\Country\Business\CountryFacadeInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\Store\Business\StoreFacadeInterface;

/**
 * @method \Pyz\Zed\CompanyBusinessUnitCsvImport\CompanyBusinessUnitCsvImportConfig getConfig()
 */
class CompanyBusinessUnitCsvImportBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CompanyBusinessUnitCsvImportHeadersValidatorInterface
     */
    public function createCompanyBusinessUnitImportCsvHeadersValidator(): CompanyBusinessUnitCsvImportHeadersValidatorInterface
    {
        return new CompanyBusinessUnitCsvImportHeadersValidator(
            $this->getUtilCsvService(),
            $this->getConfig(),
        );
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CompanyBusinessUnitCsvImportReaderInterface
     */
    public function createCompanyBusinessUnitCsvImportReader(): CompanyBusinessUnitCsvImportReaderInterface
    {
        return new CompanyBusinessUnitCsvImportReader(
            $this->getUtilCsvService(),
            $this->createCompanyBusinessUnitCsvImportMapper(),
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
        return $this->getProvidedDependency(CompanyBusinessUnitCsvImportDependencyProvider::SERVICE_UTIL_CSV);
    }

    /**
     * @return \Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CompanyBusinessUnitCsvImportMapperInterface
     */
    public function createCompanyBusinessUnitCsvImportMapper(): CompanyBusinessUnitCsvImportMapperInterface
    {
        return new CompanyBusinessUnitCsvImportMapper(
            $this->getConfig(),
        );
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CompanyBusinessUnitImportValidatorInterface
     */
    public function createCompanyBusinessUnitImportValidator(): CompanyBusinessUnitImportValidatorInterface
    {
        return new CompanyBusinessUnitImportValidator(
            $this->createCompanyBusinessUnitImportDataValidator(),
        );
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CompanyBusinessUnitImportDataValidatorInterface
     */
    protected function createCompanyBusinessUnitImportDataValidator(): CompanyBusinessUnitImportDataValidatorInterface
    {
        return new CompanyBusinessUnitImportDataValidator(
            $this->createCompanyBusinessUnitImportDataValidatorList(),
        );
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return array<\Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CsvImportDataValidator\CompanyBusinessUnitCsvImportDataValidatorInterface>
     */
    protected function createCompanyBusinessUnitImportDataValidatorList(): array
    {
        return [
            $this->createCompanyCsvDataValidator(),
            $this->createCompanyBusinessUnitCsvDataValidator(),
            $this->createCompanyUnitAddressCsvDataValidator(),
            $this->createCustomerCsvDataValidator(),
        ];
    }

    /**
     * @return \Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CsvImportDataValidator\CompanyBusinessUnitCsvImportDataValidatorInterface
     */
    protected function createCompanyCsvDataValidator(): CompanyBusinessUnitCsvImportDataValidatorInterface
    {
        return new CompanyCsvDataValidator();
    }

    /**
     * @return \Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CsvImportDataValidator\CompanyBusinessUnitCsvImportDataValidatorInterface
     */
    protected function createCompanyBusinessUnitCsvDataValidator(): CompanyBusinessUnitCsvImportDataValidatorInterface
    {
        return new CompanyBusinessUnitCsvDataValidator();
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CsvImportDataValidator\CompanyBusinessUnitCsvImportDataValidatorInterface
     */
    protected function createCompanyUnitAddressCsvDataValidator(): CompanyBusinessUnitCsvImportDataValidatorInterface
    {
        return new CompanyUnitAddressCsvDataValidator($this->getCountryFacade());
    }

    /**
     * @return \Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit\CsvImportDataValidator\CompanyBusinessUnitCsvImportDataValidatorInterface
     */
    protected function createCustomerCsvDataValidator(): CompanyBusinessUnitCsvImportDataValidatorInterface
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
        return $this->getProvidedDependency(CompanyBusinessUnitCsvImportDependencyProvider::FACADE_STORE);
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Spryker\Zed\Country\Business\CountryFacadeInterface
     */
    protected function getCountryFacade(): CountryFacadeInterface
    {
        return $this->getProvidedDependency(CompanyBusinessUnitCsvImportDependencyProvider::FACADE_COUNTRY);
    }
}
