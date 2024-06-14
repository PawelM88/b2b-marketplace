<?php

namespace Pyz\Zed\MerchantPaymentCommissionDataImport\Business\DataSet;

interface MerchantPaymentCommissionDataSetInterface
{
    /**
     * @var string
     */
    public const COLUMN_MERCHANT_REFERENCE = 'merchant_reference';

    /**
     * @var string
     */
    public const COLUMN_MERCHANT_STORE = 'merchant_store';

    /**
     * @var string
     */
    public const COLUMN_GR_PAYMENT_COMMISSION_KEY = 'gr_payment_commission_key';

    /**
     * @var string
     */
    public const COLUMN_GR_PAYMENT_COMMISSION_CAP_KEY = 'gr_payment_commission_cap_key';
}
