<?php

namespace Pyz\Zed\MerchantPage\Business\Merchant;

use Generated\Shared\Transfer\MerchantProfileCriteriaTransfer;
use Generated\Shared\Transfer\MerchantProfileTransfer;

interface MerchantFinderInterface
{
    /**
     * @param \Generated\Shared\Transfer\MerchantProfileCriteriaTransfer $merchantProfileCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantProfileTransfer|null
     */
    public function findMerchant(MerchantProfileCriteriaTransfer $merchantProfileCriteriaTransfer): ?MerchantProfileTransfer;
}
