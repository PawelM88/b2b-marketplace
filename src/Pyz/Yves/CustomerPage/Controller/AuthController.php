<?php

declare(strict_types=1);

namespace Pyz\Yves\CustomerPage\Controller;

use Generated\Shared\Transfer\TermResponseTransfer;
use Pyz\Yves\CustomerPage\CustomerPageConfig;
use Pyz\Yves\CustomerPage\Plugin\Router\CustomerPageRouteProviderPlugin;
use Spryker\Yves\Kernel\View\View;
use SprykerShop\Yves\CustomerPage\Controller\AuthController as SprykerAuthController;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @method \Pyz\Client\CustomerPage\CustomerPageClientInterface getClient()
 * @method \Pyz\Yves\CustomerPage\CustomerPageFactory getFactory()
 */
class AuthController extends SprykerAuthController
{
    /**
     * @throws \Spryker\Yves\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Spryker\Yves\Kernel\View\View|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function loginAction(): RedirectResponse|View
    {
        if (!$this->isLoggedInCustomer()) {
            $viewData = $this->executeLoginAction();

            return $this->view($viewData, [], '@CustomerPage/views/login/login.twig');
        }

        $loggedInCustomerTransfer = $this->getLoggedInCustomerTransfer();
        $termResponseTransfer = (new TermResponseTransfer())->setCustomer($loggedInCustomerTransfer);
        $termResponseTransfer = $this->getClient()->hasCustomerAcceptedAllConsents($termResponseTransfer);

        if (!$termResponseTransfer->getIsSuccess()) {
            $this->setTermResponseTransferInSession($termResponseTransfer);

            return $this->redirectResponseInternal(CustomerPageRouteProviderPlugin::ROUTE_NAME_TERM_CONSENT);
        }

        $redirectUrl = $this->getRedirectUrlFromPlugins();
        if ($redirectUrl) {
            return $this->redirectResponseExternal($redirectUrl);
        }

        return $this->redirectResponseInternal(CustomerPageRouteProviderPlugin::ROUTE_NAME_CUSTOMER_OVERVIEW);
    }

    /**
     * @param \Generated\Shared\Transfer\TermResponseTransfer $termResponseTransfer
     *
     * @throws \Spryker\Yves\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return void
     */
    protected function setTermResponseTransferInSession(TermResponseTransfer $termResponseTransfer): void
    {
        $this->getFactory()->getSessionClient()->set(CustomerPageConfig::SESSION_KEY, $termResponseTransfer);
    }
}
