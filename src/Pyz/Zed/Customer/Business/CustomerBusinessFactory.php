<?php

declare(strict_types=1);

namespace Pyz\Zed\Customer\Business;

use Pyz\Zed\Customer\Business\Customer\Customer;
use Pyz\Zed\Customer\Business\Customer\CustomerReader;
use Pyz\Zed\Customer\Business\Customer\CustomerReaderInterface;
use Spryker\Zed\Customer\Business\Customer\CustomerInterface;
use Spryker\Zed\Customer\Business\CustomerBusinessFactory as SprykerCustomerBusinessFactory;

/**
 * @method \Pyz\Zed\Customer\Persistence\CustomerRepositoryInterface getRepository()
 * @method \Spryker\Zed\Customer\Persistence\CustomerEntityManagerInterface getEntityManager()
 * @method \Pyz\Zed\Customer\CustomerConfig getConfig()
 */
class CustomerBusinessFactory extends SprykerCustomerBusinessFactory
{
    /**
     * @return \Spryker\Zed\Customer\Business\Customer\CustomerInterface
     */
    public function createCustomer(): CustomerInterface
    {
        $config = $this->getConfig();

        return new Customer(
            $this->getQueryContainer(),
            $this->createCustomerReferenceGenerator(),
            $config,
            $this->createEmailValidator(),
            $this->getMailFacade(),
            $this->getPropelQueryLocale(),
            $this->getLocaleFacade(),
            $this->createCustomerExpander(),
            $this->createCustomerPasswordPolicyValidator(),
            $this->createPasswordResetExpirationChecker(),
            $this->createCustomerPluginExecutor(),
        );
    }

    /**
     * @return \Pyz\Zed\Customer\Business\Customer\CustomerReaderInterface
     */
    public function createCustomerReader(): CustomerReaderInterface
    {
        return new CustomerReader(
            $this->getEntityManager(),
            $this->getRepository(),
            $this->createAddress(),
            $this->createCustomerExpander(),
        );
    }
}
