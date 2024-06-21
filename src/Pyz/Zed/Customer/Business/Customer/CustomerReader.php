<?php

declare(strict_types=1);

namespace Pyz\Zed\Customer\Business\Customer;

use Generated\Shared\Transfer\CustomerResponseTransfer;
use Pyz\Zed\Customer\Persistence\CustomerRepositoryInterface;
use Spryker\Zed\Customer\Business\Customer\AddressInterface;
use Spryker\Zed\Customer\Business\Customer\CustomerReader as SprykerCustomerReader;
use Spryker\Zed\Customer\Business\CustomerExpander\CustomerExpanderInterface;
use Spryker\Zed\Customer\Persistence\CustomerEntityManagerInterface;

class CustomerReader extends SprykerCustomerReader implements CustomerReaderInterface
{
    /**
     * @var \Pyz\Zed\Customer\Persistence\CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @param \Spryker\Zed\Customer\Persistence\CustomerEntityManagerInterface $customerEntityManager
     * @param \Pyz\Zed\Customer\Persistence\CustomerRepositoryInterface $customerRepository
     * @param \Spryker\Zed\Customer\Business\Customer\AddressInterface $addressManager
     * @param \Spryker\Zed\Customer\Business\CustomerExpander\CustomerExpanderInterface $customerExpander
     */
    public function __construct(
        CustomerEntityManagerInterface $customerEntityManager,
        CustomerRepositoryInterface $customerRepository,
        AddressInterface $addressManager,
        CustomerExpanderInterface $customerExpander,
    ) {
        parent::__construct($customerEntityManager, $customerRepository, $addressManager, $customerExpander);
    }

    /**
     * @param string $email
     *
     * @return \Generated\Shared\Transfer\CustomerResponseTransfer
     */
    public function getCustomerByEmail(string $email): CustomerResponseTransfer
    {
        $customerTransfer = $this->customerRepository->getCustomerByEmail($email);

        $customerResponseTransfer = (new CustomerResponseTransfer())
            ->setIsSuccess(false)
            ->setHasCustomer(false);

        if ($customerTransfer) {
            $customerTransfer->setAddresses($this->addressManager->getAddresses($customerTransfer));
            $customerResponseTransfer->setCustomerTransfer($customerTransfer)
                ->setHasCustomer(true)
                ->setIsSuccess(true);
        }

        return $customerResponseTransfer;
    }
}
