<?php

declare(strict_types=1);

namespace Pyz\Zed\Customer\Business\Customer;

use DateTime;
use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\MessageTransfer;
use Orm\Zed\Customer\Persistence\SpyCustomer;
use Spryker\Zed\Customer\Business\Customer\Customer as SprykerCustomer;

class Customer extends SprykerCustomer
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @throws \Propel\Runtime\Exception\PropelException !
     *
     * @return \Generated\Shared\Transfer\CustomerResponseTransfer
     */
    public function register(CustomerTransfer $customerTransfer): CustomerResponseTransfer
    {
        $customerResponseTransfer = $this->add($customerTransfer);

        if (!$customerResponseTransfer->getIsSuccess()) {
            return $customerResponseTransfer;
        }

        $this->customerPluginExecutor->executePostCustomerRegistrationPlugins($customerTransfer);
        $customerTransfer = $this->customerExpander->expand($customerTransfer);

        if ($customerTransfer->getSendPasswordToken()) {
            $this->sendPasswordRestoreMail($customerTransfer);
        }

        $message = static::GLOSSARY_KEY_CUSTOMER_REGISTRATION_SUCCESS;
        $messageTransfer = (new MessageTransfer())
            ->setValue($message);

        $customerResponseTransfer->setMessage($messageTransfer);

        return $customerResponseTransfer;
    }

    /**
     * @param $customerTransfer
     *
     * @throws \Propel\Runtime\Exception\PropelException !
     *
     * @return \Generated\Shared\Transfer\CustomerResponseTransfer
     */
    public function add($customerTransfer): CustomerResponseTransfer
    {
        if ($customerTransfer->getPassword()) {
            $customerResponseTransfer = $this->customerPasswordPolicyValidator->validatePassword($customerTransfer->getPassword());
            if (!$customerResponseTransfer->getIsSuccess()) {
                return $customerResponseTransfer;
            }
        }

        $customerTransfer = $this->encryptPassword($customerTransfer);

        $customerEntity = new SpyCustomer();
        $customerEntity->fromArray($customerTransfer->toArray());

        if ($customerTransfer->getLocale() !== null) {
            $this->addLocaleByLocaleName($customerEntity, $customerTransfer->getLocale()->getLocaleName());
        }

        $this->addLocale($customerEntity);

        $customerResponseTransfer = $this->createCustomerResponseTransfer();
        $customerResponseTransfer = $this->validateCustomerEmail($customerResponseTransfer, $customerEntity);
        if ($customerResponseTransfer->getIsSuccess() !== true) {
            return $customerResponseTransfer;
        }

        $customerEntity->setCustomerReference($this->customerReferenceGenerator->generateCustomerReference($customerTransfer));
        $customerEntity->setRegistered(new DateTime());

        $customerEntity->save();

        $customerTransfer->setIdCustomer($customerEntity->getPrimaryKey());
        $customerTransfer->setCustomerReference($customerEntity->getCustomerReference());
        $customerTransfer->setRegistrationKey($customerEntity->getRegistrationKey());
        $customerTransfer->setCreatedAt($customerEntity->getCreatedAt()->format('Y-m-d H:i:s.u'));
        $customerTransfer->setUpdatedAt($customerEntity->getUpdatedAt()->format('Y-m-d H:i:s.u'));

        $customerResponseTransfer
            ->setIsSuccess(true)
            ->setCustomerTransfer($customerTransfer);

        return $customerResponseTransfer;
    }
}
