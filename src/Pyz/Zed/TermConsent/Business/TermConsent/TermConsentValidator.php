<?php

declare(strict_types=1);

namespace Pyz\Zed\TermConsent\Business\TermConsent;

use Generated\Shared\Transfer\MissingTermCollectionTransfer;
use Generated\Shared\Transfer\TermCollectionTransfer;
use Generated\Shared\Transfer\TermResponseTransfer;
use Generated\Shared\Transfer\TermTransfer;
use Generated\Shared\Transfer\UpdatedTermCollectionTransfer;

class TermConsentValidator implements TermConsentValidatorInterface
{
    /**
     * @var string
     */
    protected const ERROR_TERMS_MISSING = 'customer.term_consent.error';

    /**
     * @param \Generated\Shared\Transfer\TermCollectionTransfer|null $termCollectionTransfer
     *
     * @return \Generated\Shared\Transfer\TermResponseTransfer|null
     */
    public function validateTerms(?TermCollectionTransfer $termCollectionTransfer): ?TermResponseTransfer
    {
        if (!$termCollectionTransfer) {
            return (new TermResponseTransfer())
                ->setIsSuccess(false)
                ->setErrorMessage(static::ERROR_TERMS_MISSING);
        }

        return null;
    }

    /**
     * @param \Generated\Shared\Transfer\TermCollectionTransfer $termCollectionTransfer
     * @param array<mixed> $termConsentCollection
     * @param \Generated\Shared\Transfer\TermResponseTransfer $termResponseTransfer
     *
     * @return \Generated\Shared\Transfer\TermResponseTransfer
     */
    public function verifyAcceptedTermConsents(
        TermCollectionTransfer $termCollectionTransfer,
        array $termConsentCollection,
        TermResponseTransfer $termResponseTransfer,
    ): TermResponseTransfer {
        $termResponseTransfer->setIsSuccess(true);

        $requiredTermIds = $this->extractTermIds($termCollectionTransfer);
        $acceptedTermIds = $this->extractTermConsentIds($termConsentCollection);

        $missingRequiredTermIds = array_diff($requiredTermIds, $acceptedTermIds);

        if ($missingRequiredTermIds) {
            $this->handleMissingTerms($termCollectionTransfer, $missingRequiredTermIds, $termResponseTransfer);
        }

        $requiredAcceptedTermIds = array_intersect($requiredTermIds, $acceptedTermIds);

        if ($requiredAcceptedTermIds) {
            $this->validateAcceptedTermsHasChanged(
                $termCollectionTransfer,
                $termConsentCollection,
                $requiredAcceptedTermIds,
                $termResponseTransfer,
            );
        }

        return $termResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\TermCollectionTransfer $termCollectionTransfer
     *
     * @return array<mixed>
     */
    private function extractTermIds(TermCollectionTransfer $termCollectionTransfer): array
    {
        $termIds = [];

        foreach ($termCollectionTransfer->getTerms() as $term) {
            $termIds[] = $term->getIdTerm();
        }

        return $termIds;
    }

    /**
     * @param array<mixed> $termConsentCollection
     *
     * @return array<mixed>
     */
    private function extractTermConsentIds(array $termConsentCollection): array
    {
        $termConsentIds = [];

        foreach ($termConsentCollection as $termConsent) {
            $termConsentIds[] = $termConsent->getFkTerm();
        }

        return $termConsentIds;
    }

    /**
     * @param \Generated\Shared\Transfer\TermCollectionTransfer $termCollectionTransfer
     * @param array<mixed> $missingTermIds
     * @param \Generated\Shared\Transfer\TermResponseTransfer $termResponseTransfer
     *
     * @return void
     */
    private function handleMissingTerms(
        TermCollectionTransfer $termCollectionTransfer,
        array $missingTermIds,
        TermResponseTransfer $termResponseTransfer,
    ): void {
        $missingTermCollectionTransfer = new MissingTermCollectionTransfer();

        foreach ($missingTermIds as $termId) {
            $termTransfer = new TermTransfer();

            foreach ($termCollectionTransfer->getTerms() as $term) {
                if ($termId === $term->getIdTerm()) {
                    $termTransfer->fromArray($term->toArray(), true);
                    $missingTermCollectionTransfer->addTerm($termTransfer);

                    break;
                }
            }
        }
        $termResponseTransfer->setMissingTermCollection($missingTermCollectionTransfer);
        $termResponseTransfer->setIsSuccess(false);
    }

    /**
     * @param \Generated\Shared\Transfer\TermCollectionTransfer $termCollectionTransfer
     * @param array<mixed> $termConsentCollection
     * @param array<mixed> $requiredAcceptedTermIds
     * @param \Generated\Shared\Transfer\TermResponseTransfer $termResponseTransfer
     *
     * @return void
     */
    private function validateAcceptedTermsHasChanged(
        TermCollectionTransfer $termCollectionTransfer,
        array $termConsentCollection,
        array $requiredAcceptedTermIds,
        TermResponseTransfer $termResponseTransfer,
    ): void {
        $updatedTermCollectionTransfer = new UpdatedTermCollectionTransfer();

        foreach ($requiredAcceptedTermIds as $termId) {
            $termTransfer = new TermTransfer();
            $acceptedDate = null;
            $updatedDate = null;

            foreach ($termConsentCollection as $termConsent) {
                if ($termId === $termConsent->getFkTerm()) {
                    $notFormattedAcceptedDate = $termConsent->getAcceptedAt();
                    $acceptedDate = $notFormattedAcceptedDate->format('Y-m-d H:i:s');

                    break;
                }
            }

            foreach ($termCollectionTransfer->getTerms() as $term) {
                if ($termId === $term->getIdTerm()) {
                    $updatedDate = $term->getUpdatedAt();
                    $termTransfer->fromArray($term->toArray(), true);

                    break;
                }
            }

            // Checks whether $acceptedDate and $updatedDate are not null and whether $updatedDate is greater than $acceptedDate
            if ($acceptedDate && $updatedDate && $updatedDate > $acceptedDate) {
                $updatedTermCollectionTransfer->addTerm($termTransfer);
            }
        }

        if ($updatedTermCollectionTransfer->getTerms()->count() > 0) {
            $termResponseTransfer->setUpdatedTermCollection($updatedTermCollectionTransfer);
            $termResponseTransfer->setIsSuccess(false);
        }
    }
}
