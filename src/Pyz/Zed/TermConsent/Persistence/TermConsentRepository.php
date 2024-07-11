<?php

declare(strict_types=1);

namespace Pyz\Zed\TermConsent\Persistence;

use Generated\Shared\Transfer\TermResponseTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \Pyz\Zed\TermConsent\Persistence\TermConsentPersistenceFactory getFactory()
 */
class TermConsentRepository extends AbstractRepository implements TermConsentRepositoryInterface
{
    /**
     * @param \Generated\Shared\Transfer\TermResponseTransfer $termResponseTransfer
     *
     * @return array<mixed>|null
     */
    public function findTermConsentCollectionByCustomerId(TermResponseTransfer $termResponseTransfer): ?array
    {
        $termConsentCollection = $this->getFactory()->createPyzTermConsentQuery()->findByFkCustomer(
            $termResponseTransfer->getCustomer()->getIdCustomer(),
        );

        $termConsentEntities = $termConsentCollection->getData();

        if ($termConsentEntities == null) {
            return null;
        }

        return $termConsentEntities;
    }
}
