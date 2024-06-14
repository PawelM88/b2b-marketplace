<?php

declare(strict_types=1);

namespace Pyz\Zed\MerchantPaymentCommission\Business\MerchantPaymentCommission;

use Generated\Shared\Transfer\MerchantPaymentCommissionValuesTransfer;
use Pyz\Zed\MerchantPaymentCommission\Persistence\MerchantPaymentCommissionRepositoryInterface;

class MerchantPaymentCommissionReader implements MerchantPaymentCommissionReaderInterface
{
    /**
     * @var \Pyz\Zed\MerchantPaymentCommission\Persistence\MerchantPaymentCommissionRepositoryInterface
     */
    protected MerchantPaymentCommissionRepositoryInterface $merchantPaymentCommissionRepository;

    /**
     * @param \Pyz\Zed\MerchantPaymentCommission\Persistence\MerchantPaymentCommissionRepositoryInterface $merchantPaymentCommissionRepository
     */
    public function __construct(MerchantPaymentCommissionRepositoryInterface $merchantPaymentCommissionRepository)
    {
        $this->merchantPaymentCommissionRepository = $merchantPaymentCommissionRepository;
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantPaymentCommissionValuesTransfer $merchantPaymentCommissionValues
     *
     * @return array <mixed>
     */
    public function findMerchantPaymentCommissionsPerStore(
        MerchantPaymentCommissionValuesTransfer $merchantPaymentCommissionValues,
    ): array {
        return $this->merchantPaymentCommissionRepository->findMerchantPaymentCommissionsPerStore(
            $merchantPaymentCommissionValues,
        );
    }
}
