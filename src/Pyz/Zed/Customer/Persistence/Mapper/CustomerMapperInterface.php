<?php

namespace Pyz\Zed\Customer\Persistence\Mapper;

use Generated\Shared\Transfer\CustomerTransfer;
use Orm\Zed\Customer\Persistence\SpyCustomer;
use Spryker\Zed\Customer\Persistence\Mapper\CustomerMapperInterface as SprykerCustomerMapperInterface;

interface CustomerMapperInterface extends SprykerCustomerMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     * @param \Orm\Zed\Customer\Persistence\SpyCustomer $spyCustomer
     *
     * @return \Orm\Zed\Customer\Persistence\SpyCustomer
     */
    public function mapCustomerTransferToEntity(CustomerTransfer $customerTransfer, SpyCustomer $spyCustomer): SpyCustomer;
}