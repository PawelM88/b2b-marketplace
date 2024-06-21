<?php

namespace Pyz\Zed\Customer\Persistence;

use Generated\Shared\Transfer\CustomerTransfer;
use Spryker\Zed\Customer\Persistence\CustomerRepositoryInterface as SprykerCustomerRepositoryInterface;

interface CustomerRepositoryInterface extends SprykerCustomerRepositoryInterface
{
    /**
     * @param string $customerEmail
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer|null
     */
    public function getCustomerByEmail(string $customerEmail): ?CustomerTransfer;
}
