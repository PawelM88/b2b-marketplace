<?php

declare(strict_types=1);

namespace Pyz\Zed\TermConsent\Persistence;

use Generated\Shared\Transfer\TermCollectionTransfer;
use Generated\Shared\Transfer\TermResponseTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \Pyz\Zed\TermConsent\Persistence\TermConsentPersistenceFactory getFactory()
 */
class TermConsentEntityManager extends AbstractEntityManager implements TermConsentEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\TermCollectionTransfer $termCollectionTransfer
     *
     * @throws \Propel\Runtime\Exception\PropelException !
     * @throws \Spryker\Zed\Propel\Business\Exception\AmbiguousComparisonException !
     *
     * @return \Generated\Shared\Transfer\TermResponseTransfer
     */
    public function saveAcceptedTermConsentCollection(TermCollectionTransfer $termCollectionTransfer): TermResponseTransfer
    {
        foreach ($termCollectionTransfer->getTermConsents() as $termConsent) {
            $idTerm = $termConsent->getTerm()->getIdTerm();
            $idCustomer = $termConsent->getCustomer()->getIdCustomer();
            $acceptedAt = $termConsent->getAcceptedAt();

            $termConsentEntity = $this->getFactory()->createPyzTermConsentQuery()
                ->filterByFkTerm($idTerm)
                ->filterByFkCustomer($idCustomer)
                ->findOneOrCreate();

            $termConsentEntity->setAcceptedAt($acceptedAt);

            $termConsentEntity->save();
        }

        $termResponseTransfer = new TermResponseTransfer();

        return $termResponseTransfer->setIsSuccess(true);
    }
}
