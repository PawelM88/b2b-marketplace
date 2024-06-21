<?php

namespace Pyz\Zed\Customer\Business;

use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Zed\Customer\Business\CustomerFacadeInterface as SprykerCustomerFacadeInterface;

interface CustomerFacadeInterface extends SprykerCustomerFacadeInterface
{
    /**
     * Specification:
     *  - Retrieves customer information by customer email.
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerResponseTransfer
     */
    public function getCustomerByEmail(CustomerTransfer $customerTransfer): CustomerResponseTransfer;
}
