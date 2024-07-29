<?php

declare(strict_types=1);

namespace Pyz\Zed\Customer\Persistence;

use DateTime;
use Generated\Shared\Transfer\CustomerResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Orm\Zed\Customer\Persistence\SpyCustomer;
use Orm\Zed\Locale\Persistence\SpyLocale;
use Spryker\Service\UtilText\UtilTextService;
use Spryker\Zed\Customer\Persistence\CustomerEntityManager as SprykerCustomerEntityManager;

/**
 * @method \Pyz\Zed\Customer\Persistence\CustomerPersistenceFactory getFactory()
 */
class CustomerEntityManager extends SprykerCustomerEntityManager implements CustomerEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @throws \Propel\Runtime\Exception\PropelException !
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException !
     *
     * @return \Generated\Shared\Transfer\CustomerResponseTransfer
     */
    public function saveCustomer(CustomerTransfer $customerTransfer): CustomerResponseTransfer
    {
        $customerResponseTransfer = new CustomerResponseTransfer();

        $spyCustomer = $this->findOrCreateCustomerByEmail($customerTransfer->getEmail());
        $isNew = $spyCustomer->isNew();
        $isUpdated = true;

        $spyCustomer = $this->mapCustomerTransferToEntity($customerTransfer, $spyCustomer);

        if (!$spyCustomer->getModifiedColumns()) {
            $isUpdated = false;
        }

        if ($isNew === true) {
            $spyCustomer->setCustomerReference($this->generateCustomerReference($customerTransfer));
            $spyCustomer->setRegistrationKey($this->generateKey());
        }

        $spyCustomer->setLocale($this->getCurrentLocaleEntity());
        $registeredDate = (new DateTime())->format('Y-m-d H:i:s.u');
        $spyCustomer->setRegistered($registeredDate);

        $spyCustomer->save();

        $customerTransfer->fromArray($spyCustomer->toArray(), true);
        $customerTransfer->setIsNew($isNew);
        $customerTransfer->setIsUpdated($isUpdated);

        $customerResponseTransfer->setCustomerTransfer($customerTransfer);

        return $customerResponseTransfer;
    }

    /**
     * @param string $email
     *
     * @throws \Propel\Runtime\Exception\PropelException !
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException !
     *
     * @return \Orm\Zed\Customer\Persistence\SpyCustomer
     */
    protected function findOrCreateCustomerByEmail(string $email): SpyCustomer
    {
        return $this->getFactory()
            ->createSpyCustomerQuery()
            ->filterByEmail($email)
            ->findOneOrCreate();
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     * @param \Orm\Zed\Customer\Persistence\SpyCustomer $spyCustomer
     *
     * @return \Orm\Zed\Customer\Persistence\SpyCustomer
     */
    protected function mapCustomerTransferToEntity(
        CustomerTransfer $customerTransfer,
        SpyCustomer $spyCustomer,
    ): SpyCustomer {
        return $this->getFactory()
            ->createCustomerMapper()
            ->mapCustomerTransferToEntity($customerTransfer, $spyCustomer);
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return string
     */
    protected function generateCustomerReference(CustomerTransfer $customerTransfer): string
    {
        return $this->getFactory()
            ->createCustomerReferenceGenerator()
            ->generateCustomerReference($customerTransfer);
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Orm\Zed\Locale\Persistence\SpyLocale
     */
    protected function getCurrentLocaleEntity(): SpyLocale
    {
        $localeName = $this->getFactory()->getLocaleFacade()->getCurrentLocaleName();

        return $this->getFactory()->getPropelQueryLocale()->findByLocaleName($localeName)->getFirst();
    }

    /**
     * @return string
     */
    protected function generateKey(): string
    {
        return (new UtilTextService())->generateRandomString(32);
    }
}
