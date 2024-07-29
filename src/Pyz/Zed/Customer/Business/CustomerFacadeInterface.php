<?php

namespace Pyz\Zed\Customer\Business;

use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Zed\Customer\Business\CustomerFacadeInterface as SprykerCustomerFacadeInterface;

interface CustomerFacadeInterface extends SprykerCustomerFacadeInterface
{
    /**
     * Specification:
     *  - Creates new or updates existed customer.
     *  - Customer is filtering by email.
     *  - Assigns current locale to customer.
     *  - Generates customer reference for customer.
     *  - Stores customer data.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerResponseTransfer
     */
    public function createCustomer(CustomerTransfer $customerTransfer): CustomerResponseTransfer;
}
