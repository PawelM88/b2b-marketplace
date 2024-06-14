<?php

declare(strict_types=1);

namespace Pyz\Zed\MerchantPaymentCommission\Business\MerchantPaymentCommission;

use Generated\Shared\Transfer\MerchantPaymentCommissionTransfer;
use Generated\Shared\Transfer\MerchantResponseTransfer;
use Generated\Shared\Transfer\MerchantTransfer;
use Pyz\Zed\MerchantPaymentCommission\Persistence\MerchantPaymentCommissionEntityManagerInterface;
use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionTrait;

class MerchantPaymentCommissionWriter implements MerchantPaymentCommissionWriterInterface
{
    use TransactionTrait;

    /**
     * @var \Pyz\Zed\MerchantPaymentCommission\Persistence\MerchantPaymentCommissionEntityManagerInterface
     */
    protected MerchantPaymentCommissionEntityManagerInterface $merchantPaymentCommissionEntityManager;

    /**
     * @param \Pyz\Zed\MerchantPaymentCommission\Persistence\MerchantPaymentCommissionEntityManagerInterface $merchantPaymentCommissionEntityManager
     */
    public function __construct(MerchantPaymentCommissionEntityManagerInterface $merchantPaymentCommissionEntityManager)
    {
        $this->merchantPaymentCommissionEntityManager = $merchantPaymentCommissionEntityManager;
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantPaymentCommissionTransfer $merchantPaymentCommissionTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantPaymentCommissionTransfer
     */
    public function createMerchantPaymentCommission(MerchantPaymentCommissionTransfer $merchantPaymentCommissionTransfer): MerchantPaymentCommissionTransfer
    {
        return $this->getTransactionHandler()->handleTransaction(function () use ($merchantPaymentCommissionTransfer) {
            return $this->executeCreateTransaction($merchantPaymentCommissionTransfer);
        });
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantTransfer $merchantTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantResponseTransfer
     */
    public function postUpdateMerchantPaymentCommission(MerchantTransfer $merchantTransfer): MerchantResponseTransfer
    {
        $merchantResponseTransfer = (new MerchantResponseTransfer())->setIsSuccess(true);

        if (!$merchantTransfer->getMerchantPaymentCommission()) {
            return $merchantResponseTransfer->setMerchant($merchantTransfer);
        }

        $merchantPaymentCommissionTransfer = $this->update($merchantTransfer);

        return $merchantResponseTransfer->setMerchant(
            $merchantTransfer->setMerchantPaymentCommission($merchantPaymentCommissionTransfer),
        );
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantPaymentCommissionTransfer $merchantPaymentCommissionTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantPaymentCommissionTransfer
     */
    protected function executeCreateTransaction(MerchantPaymentCommissionTransfer $merchantPaymentCommissionTransfer): MerchantPaymentCommissionTransfer
    {
        $merchantPaymentCommissionsPerStore = $merchantPaymentCommissionTransfer->getMerchantPaymentCommissionPerStore(
        );

        foreach ($merchantPaymentCommissionsPerStore as $merchantPaymentCommissionPerStore) {
            $fkMerchant = $merchantPaymentCommissionTransfer->getFkMerchant();
            $merchantPaymentCommissionValues = $merchantPaymentCommissionPerStore->getMerchantPaymentCommissionValues();

            $merchantPaymentCommissionTransfer->fromArray($merchantPaymentCommissionValues->toArray());
            $merchantPaymentCommissionTransfer->setFkMerchant($fkMerchant);

            $merchantPaymentCommissionTransfer = $this->merchantPaymentCommissionEntityManager->create(
                $merchantPaymentCommissionTransfer,
            );
        }

        return $merchantPaymentCommissionTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantTransfer $merchantTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantPaymentCommissionTransfer
     */
    protected function update(MerchantTransfer $merchantTransfer): MerchantPaymentCommissionTransfer
    {
        return $this->getTransactionHandler()->handleTransaction(function () use ($merchantTransfer) {
            return $this->executeUpdateTransaction($merchantTransfer);
        });
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantTransfer $merchantTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantPaymentCommissionTransfer
     */
    protected function executeUpdateTransaction(MerchantTransfer $merchantTransfer): MerchantPaymentCommissionTransfer
    {
        $merchantPaymentCommissionTransfer = $merchantTransfer->getMerchantPaymentCommission();
        $merchantPaymentCommissionsPerStore = $merchantPaymentCommissionTransfer->getMerchantPaymentCommissionPerStore(
        );

        foreach ($merchantPaymentCommissionsPerStore as $merchantPaymentCommissionPerStore) {
            $merchantPaymentCommissionValues = $merchantPaymentCommissionPerStore->getMerchantPaymentCommissionValues();

            if (!$merchantPaymentCommissionValues->getFkMerchant()) {
                $merchantPaymentCommissionValues->setFkMerchant($merchantTransfer->getIdMerchant());
            }

            $this->merchantPaymentCommissionEntityManager->update(
                $merchantPaymentCommissionValues,
            );
        }

        return $merchantPaymentCommissionTransfer->setMerchantPaymentCommissionPerStore(
            $merchantPaymentCommissionsPerStore,
        );
    }
}
