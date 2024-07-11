<?php

declare(strict_types=1);

namespace Pyz\Yves\CustomerPage\Plugin;

use DateTime;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\TermCollectionTransfer;
use Generated\Shared\Transfer\TermConsentTransfer;
use Generated\Shared\Transfer\TermResponseTransfer;
use Generated\Shared\Transfer\TermTransfer;
use Spryker\Client\CmsStorage\CmsStorageClientInterface;
use Spryker\Client\Store\StoreClientInterface;
use Spryker\Yves\Kernel\AbstractPlugin;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class TermHandler extends AbstractPlugin
{
    /**
     * @param \Spryker\Client\CmsStorage\CmsStorageClientInterface $cmsStorageClient
     * @param \Spryker\Client\Store\StoreClientInterface $storeClient
     */
    public function __construct(
        protected CmsStorageClientInterface $cmsStorageClient,
        protected StoreClientInterface $storeClient,
    ) {
    }

    /**
     * @param \Generated\Shared\Transfer\TermResponseTransfer $termResponseTransfer
     *
     * @return array<mixed>
     */
    public function mergeMissingAndUpdatedTerms(TermResponseTransfer $termResponseTransfer): array
    {
        $missingTerms =
            $termResponseTransfer->getMissingTermCollection() ? iterator_to_array(
                $termResponseTransfer
                    ->getMissingTermCollection()->getTerms(),
            ) : [];
        $updatedTerms =
            $termResponseTransfer->getUpdatedTermCollection() ? iterator_to_array(
                $termResponseTransfer
                    ->getUpdatedTermCollection()->getTerms(),
            ) : [];

        return array_merge($missingTerms, $updatedTerms);
    }

    /**
     * @param \Generated\Shared\Transfer\TermResponseTransfer $termResponseTransfer
     * @param \Symfony\Component\Form\FormInterface $formContent
     * @param array<mixed> $termsRequiringAcceptance
     *
     * @return \Generated\Shared\Transfer\TermCollectionTransfer
     */
    public function prepareAcceptedTermCollectionTransfer(
        TermResponseTransfer $termResponseTransfer,
        FormInterface $formContent,
        array $termsRequiringAcceptance,
    ): TermCollectionTransfer {
        $termCollectionTransfer = new TermCollectionTransfer();
        $idCustomer = $termResponseTransfer->getCustomer()->getIdCustomer();

        foreach ($formContent as $field) {
            $termKey = $field->getName();

            $termTransfer = new TermTransfer();
            $customerTransfer = new CustomerTransfer();

            foreach ($termsRequiringAcceptance as $term) {
                if ($term->getTermKey() === $termKey) {
                    $termTransfer->setIdTerm($term->getIdTerm());
                    $customerTransfer->setIdCustomer($idCustomer);

                    $termConsentTransfer = new TermConsentTransfer();
                    $termConsentTransfer->setAcceptedAt((new DateTime())->format('Y-m-d H:i:s'));
                    $termConsentTransfer->setTerm($termTransfer);
                    $termConsentTransfer->setCustomer($customerTransfer);

                    $termCollectionTransfer->addTermConsent($termConsentTransfer);

                    break;
                }
            }
        }

        return $termCollectionTransfer;
    }

    /**
     * @param array<Object> $termsRequiringAcceptance
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return void
     */
    public function storeAllowedLinksInSession(array $termsRequiringAcceptance, Request $request): void
    {
        $linkUrls = [];
        foreach ($termsRequiringAcceptance as $term) {
            $linkUrls[] = $term->getTermUrl();
        }

        $session = $request->getSession();
        $session->set('allowed_link_urls', $linkUrls);
    }
}
