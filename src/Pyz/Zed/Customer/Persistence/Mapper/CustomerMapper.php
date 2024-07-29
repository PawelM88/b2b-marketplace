<?php

declare(strict_types=1);

namespace Pyz\Zed\Customer\Persistence\Mapper;

use Generated\Shared\Transfer\CustomerTransfer;
use Orm\Zed\Customer\Persistence\SpyCustomer;
use Spryker\Zed\Customer\Persistence\Mapper\CustomerMapper as SprykerCustomerMapper;

class CustomerMapper extends SprykerCustomerMapper implements CustomerMapperInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     * @param \Orm\Zed\Customer\Persistence\SpyCustomer $spyCustomer
     *
     * @return \Orm\Zed\Customer\Persistence\SpyCustomer
     */
    public function mapCustomerTransferToEntity(CustomerTransfer $customerTransfer, SpyCustomer $spyCustomer): SpyCustomer
    {
        $spyCustomer->fromArray(
            $customerTransfer->modifiedToArray(false),
        );

        return $spyCustomer;
    }
}
