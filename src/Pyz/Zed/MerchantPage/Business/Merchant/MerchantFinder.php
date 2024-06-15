<?php

declare(strict_types=1);

namespace Pyz\Zed\MerchantPage\Business\Merchant;

use Generated\Shared\Transfer\MerchantProfileCriteriaTransfer;
use Generated\Shared\Transfer\MerchantProfileTransfer;
use Spryker\Zed\MerchantProfile\Business\MerchantProfileFacadeInterface;

class MerchantFinder implements MerchantFinderInterface
{
    /**
     * @param \Spryker\Zed\MerchantProfile\Business\MerchantProfileFacadeInterface $merchantProfileFacade
     */
    public function __construct(protected MerchantProfileFacadeInterface $merchantProfileFacade)
    {
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantProfileCriteriaTransfer $merchantProfileCriteriaTransfer
     *
     * @return \Generated\Shared\Transfer\MerchantProfileTransfer|null
     */
    public function findMerchant(MerchantProfileCriteriaTransfer $merchantProfileCriteriaTransfer): ?MerchantProfileTransfer
    {
        return $this->merchantProfileFacade->findOne($merchantProfileCriteriaTransfer);
    }
}
