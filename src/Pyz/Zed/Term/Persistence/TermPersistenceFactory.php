<?php

declare(strict_types=1);

namespace Pyz\Zed\Term\Persistence;

use Orm\Zed\Term\Persistence\PyzTermQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \Pyz\Zed\Term\Persistence\TermRepositoryInterface getRepository()
 */
class TermPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\Term\Persistence\PyzTermQuery
     */
    public function createPyzTermQuery(): PyzTermQuery
    {
        return new PyzTermQuery();
    }
}
