<?php

declare(strict_types=1);

namespace Pyz\Zed\TermConsent\Persistence;

use Orm\Zed\Term\Persistence\PyzTermConsentQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \Pyz\Zed\TermConsent\Persistence\TermConsentRepositoryInterface getRepository()
 * @method \Pyz\Zed\TermConsent\Persistence\TermConsentEntityManagerInterface getEntityManager()
 */
class TermConsentPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Term\Persistence\PyzTermConsentQuery
     */
    public function createPyzTermConsentQuery(): PyzTermConsentQuery
    {
        return PyzTermConsentQuery::create();
    }
}
