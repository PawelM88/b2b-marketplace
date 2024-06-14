<?php

declare(strict_types=1);

namespace Pyz\Zed\MerchantPaymentCommission\Persistence;

use Orm\Zed\MerchantPaymentCommission\Persistence\PyzMerchantPaymentCommissionQuery;
use Pyz\Zed\MerchantPaymentCommission\MerchantPaymentCommissionDependencyProvider;
use Pyz\Zed\MerchantPaymentCommission\Persistence\Propel\Mapper\MerchantPaymentCommissionMapper;
use Pyz\Zed\MerchantPaymentCommission\Persistence\Propel\Mapper\MerchantPaymentCommissionMapperInterface;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;
use Spryker\Zed\Store\Business\StoreFacadeInterface;

/**
 * @method \Pyz\Zed\MerchantPaymentCommission\Persistence\MerchantPaymentCommissionRepositoryInterface getRepository()
 * @method \Pyz\Zed\MerchantPaymentCommission\Persistence\MerchantPaymentCommissionEntityManagerInterface getEntityManager()
 * @method \Pyz\Zed\MerchantPaymentCommission\MerchantPaymentCommissionConfig getConfig()
 */
class MerchantPaymentCommissionPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\MerchantPaymentCommission\Persistence\PyzMerchantPaymentCommissionQuery
     */
    public function createMerchantPaymentCommissionQuery(): PyzMerchantPaymentCommissionQuery
    {
        return PyzMerchantPaymentCommissionQuery::create();
    }

    /**
     * @return \Pyz\Zed\MerchantPaymentCommission\Persistence\Propel\Mapper\MerchantPaymentCommissionMapperInterface
     */
    public function createPropelMerchantPaymentCommissionMapper(): MerchantPaymentCommissionMapperInterface
    {
        return new MerchantPaymentCommissionMapper();
    }

    /**
     * @return \Spryker\Zed\Store\Business\StoreFacadeInterface
     */
    public function getStoreFacade(): StoreFacadeInterface
    {
        return $this->getProvidedDependency(MerchantPaymentCommissionDependencyProvider::FACADE_STORE);
    }
}
