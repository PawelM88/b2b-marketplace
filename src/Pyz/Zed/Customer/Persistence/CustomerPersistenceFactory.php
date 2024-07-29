<?php

declare(strict_types=1);

namespace Pyz\Zed\Customer\Persistence;

use Orm\Zed\Locale\Persistence\SpyLocaleQuery;
use Pyz\Zed\Customer\CustomerDependencyProvider;
use Pyz\Zed\Customer\Persistence\Mapper\CustomerMapper;
use Pyz\Zed\Customer\Persistence\Mapper\CustomerMapperInterface;
use Spryker\Zed\Customer\Business\ReferenceGenerator\CustomerReferenceGenerator;
use Spryker\Zed\Customer\Business\ReferenceGenerator\CustomerReferenceGeneratorInterface;
use Spryker\Zed\Customer\Dependency\Facade\CustomerToSequenceNumberBridge;
use Spryker\Zed\Customer\Dependency\Facade\CustomerToStoreFacadeInterface;
use Spryker\Zed\Customer\Persistence\CustomerPersistenceFactory as SprykerCustomerPersistenceFactory;
use Spryker\Zed\Locale\Business\LocaleFacadeInterface;

/**
 * @method \Pyz\Zed\Customer\CustomerConfig getConfig()
 * @method \Spryker\Zed\Customer\Persistence\CustomerRepositoryInterface getRepository()
 * @method \Pyz\Zed\Customer\Persistence\CustomerEntityManagerInterface getEntityManager()
 */
class CustomerPersistenceFactory extends SprykerCustomerPersistenceFactory
{
    /**
     * @return \Pyz\Zed\Customer\Persistence\Mapper\CustomerMapperInterface
     */
    public function createCustomerMapper(): CustomerMapperInterface
    {
        return new CustomerMapper();
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Spryker\Zed\Customer\Business\ReferenceGenerator\CustomerReferenceGeneratorInterface
     */
    public function createCustomerReferenceGenerator(): CustomerReferenceGeneratorInterface
    {
        return new CustomerReferenceGenerator(
            $this->getSequenceNumberFacade(),
            $this->getStoreFacade(),
            $this->getConfig(),
        );
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Spryker\Zed\Locale\Business\LocaleFacadeInterface
     */
    public function getLocaleFacade(): LocaleFacadeInterface
    {
        return $this->getProvidedDependency(CustomerDependencyProvider::FACADE_LOCALE);
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Orm\Zed\Locale\Persistence\SpyLocaleQuery
     */
    public function getPropelQueryLocale(): SpyLocaleQuery
    {
        return $this->getProvidedDependency(CustomerDependencyProvider::PROPEL_QUERY_LOCALE);
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Spryker\Zed\Customer\Dependency\Facade\CustomerToSequenceNumberBridge
     */
    protected function getSequenceNumberFacade(): CustomerToSequenceNumberBridge
    {
        return $this->getProvidedDependency(CustomerDependencyProvider::FACADE_SEQUENCE_NUMBER);
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Spryker\Zed\Customer\Dependency\Facade\CustomerToStoreFacadeInterface
     */
    protected function getStoreFacade(): CustomerToStoreFacadeInterface
    {
        return $this->getProvidedDependency(CustomerDependencyProvider::FACADE_STORE);
    }
}
