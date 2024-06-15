<?php

declare(strict_types=1);

namespace Pyz\Yves\MerchantPage;

use Pyz\Yves\MerchantPage\Form\MerchantPageFormFactory;
use SprykerShop\Yves\MerchantPage\MerchantPageFactory as SprykerMerchantPageFactory;

class MerchantPageFactory extends SprykerMerchantPageFactory
{
    /**
     * @return \Pyz\Yves\MerchantPage\Form\MerchantPageFormFactory
     */
    public function createMerchantFormFactory(): MerchantPageFormFactory
    {
        return new MerchantPageFormFactory();
    }
}
