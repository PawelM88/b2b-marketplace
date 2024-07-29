<?php

declare(strict_types=1);

namespace Pyz\Zed\Customer\Business;

use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Zed\Customer\Business\CustomerFacade as SprykerCustomerFacade;

/**
 * @method \Pyz\Zed\Customer\Business\CustomerBusinessFactory getFactory()
 * @method \Spryker\Zed\Customer\Persistence\CustomerRepositoryInterface getRepository()
 * @method \Pyz\Zed\Customer\Persistence\CustomerEntityManagerInterface getEntityManager()
 */
class CustomerFacade extends SprykerCustomerFacade implements CustomerFacadeInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerResponseTransfer
     */
    public function createCustomer(CustomerTransfer $customerTransfer): CustomerResponseTransfer
    {
        return $this->getFactory()->createCustomer()->createCustomer($customerTransfer);
    }
}
