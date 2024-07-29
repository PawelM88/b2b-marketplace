<?php

declare(strict_types=1);

namespace Pyz\Zed\Customer\Business\Customer;

use DateTime;
use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\MessageTransfer;
use Orm\Zed\Customer\Persistence\SpyCustomer;
use Orm\Zed\Locale\Persistence\SpyLocaleQuery;
use Pyz\Zed\Customer\Persistence\CustomerEntityManagerInterface;
use Spryker\Zed\Customer\Business\Customer\Checker\PasswordResetExpirationCheckerInterface;
use Spryker\Zed\Customer\Business\Customer\Customer as SprykerCustomer;
use Spryker\Zed\Customer\Business\Customer\EmailValidatorInterface;
use Spryker\Zed\Customer\Business\CustomerExpander\CustomerExpanderInterface;
use Spryker\Zed\Customer\Business\CustomerPasswordPolicy\CustomerPasswordPolicyValidatorInterface;
use Spryker\Zed\Customer\Business\Executor\CustomerPluginExecutorInterface;
use Spryker\Zed\Customer\Business\ReferenceGenerator\CustomerReferenceGeneratorInterface;
use Spryker\Zed\Customer\CustomerConfig;
use Spryker\Zed\Customer\Dependency\Facade\CustomerToLocaleInterface;
use Spryker\Zed\Customer\Dependency\Facade\CustomerToMailInterface;
use Spryker\Zed\Customer\Persistence\CustomerQueryContainerInterface;

class Customer extends SprykerCustomer implements CustomerInterface
{
    /**
     * @param \Spryker\Zed\Customer\Persistence\CustomerQueryContainerInterface $queryContainer
     * @param \Spryker\Zed\Customer\Business\ReferenceGenerator\CustomerReferenceGeneratorInterface $customerReferenceGenerator
     * @param \Spryker\Zed\Customer\CustomerConfig $customerConfig
     * @param \Spryker\Zed\Customer\Business\Customer\EmailValidatorInterface $emailValidator
     * @param \Spryker\Zed\Customer\Dependency\Facade\CustomerToMailInterface $mailFacade
     * @param \Orm\Zed\Locale\Persistence\SpyLocaleQuery $localePropelQuery
     * @param \Spryker\Zed\Customer\Dependency\Facade\CustomerToLocaleInterface $localeFacade
     * @param \Spryker\Zed\Customer\Business\CustomerExpander\CustomerExpanderInterface $customerExpander
     * @param \Spryker\Zed\Customer\Business\CustomerPasswordPolicy\CustomerPasswordPolicyValidatorInterface $customerPasswordPolicyValidator
     * @param \Spryker\Zed\Customer\Business\Customer\Checker\PasswordResetExpirationCheckerInterface $passwordResetExpirationChecker
     * @param \Spryker\Zed\Customer\Business\Executor\CustomerPluginExecutorInterface $customerPluginExecutor
     * @param \Pyz\Zed\Customer\Persistence\CustomerEntityManagerInterface $customerEntityManager
     */
    public function __construct(
        CustomerQueryContainerInterface $queryContainer,
        CustomerReferenceGeneratorInterface $customerReferenceGenerator,
        CustomerConfig $customerConfig,
        EmailValidatorInterface $emailValidator,
        CustomerToMailInterface $mailFacade,
        SpyLocaleQuery $localePropelQuery,
        CustomerToLocaleInterface $localeFacade,
        CustomerExpanderInterface $customerExpander,
        CustomerPasswordPolicyValidatorInterface $customerPasswordPolicyValidator,
        PasswordResetExpirationCheckerInterface $passwordResetExpirationChecker,
        CustomerPluginExecutorInterface $customerPluginExecutor,
        protected CustomerEntityManagerInterface $customerEntityManager,
    ) {
        parent::__construct(
            $queryContainer,
            $customerReferenceGenerator,
            $customerConfig,
            $emailValidator,
            $mailFacade,
            $localePropelQuery,
            $localeFacade,
            $customerExpander,
            $customerPasswordPolicyValidator,
            $passwordResetExpirationChecker,
            $customerPluginExecutor,
        );
    }

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
        $registeredDate = (new DateTime())->format('Y-m-d H:i:s.u');
        $customerEntity->setRegistered($registeredDate);

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

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\CustomerResponseTransfer
     */
    public function createCustomer(CustomerTransfer $customerTransfer): CustomerResponseTransfer
    {
        return $this->customerEntityManager->saveCustomer($customerTransfer);
    }
}
