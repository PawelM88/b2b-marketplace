<?php

declare(strict_types=1);

namespace Pyz\Zed\TermConsent\Business\TermConsent;

use Generated\Shared\Transfer\TermResponseTransfer;
use Pyz\Zed\Term\Business\TermFacadeInterface;
use Pyz\Zed\TermConsent\Persistence\Mapper\TermConsentMapperInterface;
use Pyz\Zed\TermConsent\Persistence\TermConsentRepositoryInterface;

class TermConsentReader implements TermConsentReaderInterface
{
    /**
     * @param \Pyz\Zed\TermConsent\Persistence\TermConsentRepositoryInterface $termConsentRepository
     * @param \Pyz\Zed\Term\Business\TermFacadeInterface $termFacade
     * @param \Pyz\Zed\TermConsent\Business\TermConsent\TermConsentValidatorInterface $termConsentValidator
     * @param \Pyz\Zed\TermConsent\Persistence\Mapper\TermConsentMapperInterface $termConsentMapper
     */
    public function __construct(
        protected TermConsentRepositoryInterface $termConsentRepository,
        protected TermFacadeInterface $termFacade,
        protected TermConsentValidatorInterface $termConsentValidator,
        protected TermConsentMapperInterface $termConsentMapper,
    ) {
    }

    /**
     * @param \Generated\Shared\Transfer\TermResponseTransfer $termResponseTransfer
     *
     * @return \Generated\Shared\Transfer\TermResponseTransfer
     */
    public function hasCustomerAcceptedAllConsents(TermResponseTransfer $termResponseTransfer): TermResponseTransfer
    {
        $termCollectionTransfer = $this->termFacade->getAllTerms();

        $errorTermResponseTransfer = $this->termConsentValidator->validateTerms($termCollectionTransfer);

        if ($errorTermResponseTransfer) {
            return $errorTermResponseTransfer;
        }

        $termConsentCollection = $this->termConsentRepository->findTermConsentCollectionByCustomerId(
            $termResponseTransfer,
        );

        if (!$termConsentCollection) {
            $missingTermCollectionTransfer = $this->termConsentMapper->mapAllNotConsentedTerms($termCollectionTransfer);

            return $termResponseTransfer
                ->setMissingTermCollection($missingTermCollectionTransfer)
                ->setIsSuccess(false);
        }

        return $this->termConsentValidator->verifyAcceptedTermConsents($termCollectionTransfer, $termConsentCollection, $termResponseTransfer);
    }
}
