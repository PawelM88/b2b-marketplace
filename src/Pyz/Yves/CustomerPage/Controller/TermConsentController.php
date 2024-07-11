<?php

declare(strict_types=1);

namespace Pyz\Yves\CustomerPage\Controller;

use Generated\Shared\Transfer\TermResponseTransfer;
use Pyz\Yves\CustomerPage\CustomerPageConfig;
use Pyz\Yves\CustomerPage\Plugin\Router\CustomerPageRouteProviderPlugin;
use Pyz\Yves\CustomerPage\Plugin\TermHandler;
use Spryker\Yves\Kernel\Controller\AbstractController;
use Spryker\Yves\Kernel\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Client\CustomerPage\CustomerPageClientInterface getClient()
 * @method \Pyz\Yves\CustomerPage\CustomerPageFactory getFactory()
 */
class TermConsentController extends AbstractController
{
    /**
     * @var string
     */
    protected const GLOSSARY_KEY_CUSTOMER_TERM_CONSENT_ACCEPT_ALL = 'customer.term_consent_accept_all';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @throws \Spryker\Yves\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Spryker\Yves\Kernel\View\View
     */
    public function acceptTermsAction(Request $request): RedirectResponse|View
    {
        $viewData = $this->executeAcceptTermsAction($request);

        if ($viewData instanceof RedirectResponse) {
            return $viewData;
        }

        return $this->view($viewData, [], '@CustomerPage/views/term-consent/accept-terms.twig');
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @throws \Spryker\Yves\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array<mixed>
     */
    protected function executeAcceptTermsAction(Request $request): RedirectResponse|array
    {
        $termResponseTransfer = $this->getTermResponseTransferFromSession();

        if (!$termResponseTransfer) {
            return $this->redirectResponseInternal(
                CustomerPageRouteProviderPlugin::ROUTE_NAME_LOGIN,
            );
        }

        $errorMessage = $termResponseTransfer->getErrorMessage();

        $viewData = [
            'error' => $errorMessage,
        ];

        if ($errorMessage) {
            return $viewData;
        }

        $termHandler = $this->getTermHandler();
        $termsRequiringAcceptance = $termHandler->mergeMissingAndUpdatedTerms($termResponseTransfer);

        $termConsentForm = $this
            ->getFactory()
            ->createCustomerFormFactory()
            ->getTermConsentForm($termsRequiringAcceptance);

        $formContent = $termConsentForm->handleRequest($request);

        if ($formContent->isSubmitted()) {
            foreach ($formContent as $field) {
                if ($field->isRequired() && $field->getData() !== true) {
                    $this->addErrorMessage(static::GLOSSARY_KEY_CUSTOMER_TERM_CONSENT_ACCEPT_ALL);

                    return $this->redirectResponseInternal(
                        CustomerPageRouteProviderPlugin::ROUTE_NAME_TERM_CONSENT,
                    );
                }
            }

            if (!$formContent->isValid()) {
                return $this->redirectResponseInternal(CustomerPageRouteProviderPlugin::ROUTE_NAME_TERM_CONSENT);
            }

            $termCollectionTransfer = $termHandler->prepareAcceptedTermCollectionTransfer(
                $termResponseTransfer,
                $formContent,
                $termsRequiringAcceptance,
            );

            $this->getClient()->saveAcceptedTermConsentCollection($termCollectionTransfer);

            $session = $request->getSession();
            $session->set('form_filled', true);

            return $this->redirectResponseInternal(CustomerPageRouteProviderPlugin::ROUTE_NAME_CUSTOMER_OVERVIEW);
        }

        $termHandler->storeAllowedLinksInSession($termsRequiringAcceptance, $request);

        $viewData['termConsentForm'] = $termConsentForm->createView();

        return $viewData;
    }

    /**
     * @throws \Spryker\Yves\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Generated\Shared\Transfer\TermResponseTransfer|null
     */
    protected function getTermResponseTransferFromSession(): ?TermResponseTransfer
    {
        return $this->getFactory()->getSessionClient()->get(CustomerPageConfig::SESSION_KEY);
    }

    /**
     * @throws \Spryker\Yves\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Yves\CustomerPage\Plugin\TermHandler
     */
    protected function getTermHandler(): TermHandler
    {
        return $this->getFactory()
            ->getTermHandler();
    }
}
