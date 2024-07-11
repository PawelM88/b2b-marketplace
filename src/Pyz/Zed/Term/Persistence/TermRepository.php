<?php

declare(strict_types=1);

namespace Pyz\Zed\Term\Persistence;

use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \Pyz\Zed\Term\Persistence\TermPersistenceFactory getFactory()
 */
class TermRepository extends AbstractRepository implements TermRepositoryInterface
{
    /**
     * @return array<mixed>|null
     */
    public function getAllTerms(): ?array
    {
        $termCollection = $this->getFactory()->createPyzTermQuery()->find()->getData();

        if (!$termCollection) {
            return null;
        }

        return $termCollection;
    }
}
