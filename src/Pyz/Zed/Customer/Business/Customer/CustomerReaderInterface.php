<?php

namespace Pyz\Zed\Customer\Business\Customer;

use Generated\Shared\Transfer\CustomerResponseTransfer;
use Spryker\Zed\Customer\Business\Customer\CustomerReaderInterface as SprykerCustomerReaderInterface;

interface CustomerReaderInterface extends SprykerCustomerReaderInterface
{
    /**
     * @param string $email
     *
     * @return \Generated\Shared\Transfer\CustomerResponseTransfer
     */
    public function getCustomerByEmail(string $email): CustomerResponseTransfer;
}
