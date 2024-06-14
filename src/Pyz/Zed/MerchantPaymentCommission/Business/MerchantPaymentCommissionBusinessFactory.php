<?php

declare(strict_types=1);

namespace Pyz\Zed\MerchantPaymentCommission\Business;

use Pyz\Zed\MerchantPaymentCommission\Business\MerchantPaymentCommission\MerchantPaymentCommissionReader;
use Pyz\Zed\MerchantPaymentCommission\Business\MerchantPaymentCommission\MerchantPaymentCommissionReaderInterface;
use Pyz\Zed\MerchantPaymentCommission\Business\MerchantPaymentCommission\MerchantPaymentCommissionWriter;
use Pyz\Zed\MerchantPaymentCommission\Business\MerchantPaymentCommission\MerchantPaymentCommissionWriterInterface;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Pyz\Zed\MerchantPaymentCommission\Persistence\MerchantPaymentCommissionRepositoryInterface getRepository()
 * @method \Pyz\Zed\MerchantPaymentCommission\Persistence\MerchantPaymentCommissionEntityManagerInterface getEntityManager()
 * @method \Pyz\Zed\MerchantPaymentCommission\MerchantPaymentCommissionConfig getConfig()
 */
class MerchantPaymentCommissionBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Pyz\Zed\MerchantPaymentCommission\Business\MerchantPaymentCommission\MerchantPaymentCommissionWriterInterface
     */
    public function createMerchantPaymentCommissionWriter(): MerchantPaymentCommissionWriterInterface
    {
        return new MerchantPaymentCommissionWriter(
            $this->getEntityManager(),
        );
    }

    /**
     * @return \Pyz\Zed\MerchantPaymentCommission\Business\MerchantPaymentCommission\MerchantPaymentCommissionReaderInterface
     */
    public function createMerchantPaymentCommissionReader(): MerchantPaymentCommissionReaderInterface
    {
        return new MerchantPaymentCommissionReader(
            $this->getRepository(),
        );
    }
}
