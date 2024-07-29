<?php

namespace Pyz\Zed\Customer\Persistence;

use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Zed\Customer\Persistence\CustomerEntityManagerInterface as SprykerCustomerEntityManagerInterface;

interface CustomerEntityManagerInterface extends SprykerCustomerEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerResponseTransfer
     */
    public function saveCustomer(CustomerTransfer $customerTransfer): CustomerResponseTransfer;
}
