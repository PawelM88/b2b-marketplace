<?php

declare(strict_types=1);

namespace Pyz\Yves\CustomerPage\Plugin\EventDispatcher;

use Pyz\Yves\CustomerPage\Plugin\Router\CustomerPageRouteProviderPlugin;
use Spryker\Service\Container\ContainerInterface;
use Spryker\Shared\EventDispatcher\EventDispatcherInterface;
use Spryker\Shared\EventDispatcherExtension\Dependency\Plugin\EventDispatcherPluginInterface;
use Spryker\Yves\Kernel\AbstractPlugin;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class TermConsentEventDispatcherPlugin extends AbstractPlugin implements EventDispatcherPluginInterface
{
    /**
     * @var string
     */
    protected const DEFAULT_LANGUAGE = 'en';

    /**
     * @var string
     */
    protected const SUBSCRIBE_URL = '/en/newsletter/subscribe';

    /**
     * @var string
     */
    protected const LOGIN_URL = '/en/login';

    /**
     * @param \Spryker\Shared\EventDispatcher\EventDispatcherInterface $eventDispatcher
     * @param \Spryker\Service\Container\ContainerInterface $container
     *
     * @return \Spryker\Shared\EventDispatcher\EventDispatcherInterface
     */
    public function extend(
        EventDispatcherInterface $eventDispatcher,
        ContainerInterface $container,
    ): EventDispatcherInterface {
        $eventDispatcher->addListener(KernelEvents::REQUEST, function (RequestEvent $event): RequestEvent {
            return $this->onKernelRequest($event);
        });

        return $eventDispatcher;
    }

    /**
     * @param \Symfony\Component\HttpKernel\Event\RequestEvent $event
     *
     * @return \Symfony\Component\HttpKernel\Event\RequestEvent
     */
    protected function onKernelRequest(RequestEvent $event): RequestEvent
    {
        $request = $event->getRequest();
        $session = $request->getSession();

        // The parsed URL of the page the user was on
        $refererPath = $this->getRefererPath($request);

        if ($refererPath) {
            $allowedLinkUrls = $session->get('allowed_link_urls', []);

            // Checks whether the page the user wants to go to is a page with a specific term that must be accepted
            if ($this->isAllowedLink($refererPath, $allowedLinkUrls, $request, $event)) {
                return $event;
            }

            // The parsed URL of the page with term consent form
            $termConsentFormUrl = $this->createTermConsentFormParsedUrl($event);

            // Checking whether the page the user was on is a page with a term consent form
            if ($refererPath !== $termConsentFormUrl) {
                return $event;
            }

            // Based on the flag 'form_filled' in the session, it checks whether the form has been submitted
            if (!$this->isFormFilled($session)) {
                $this->handleUnfilledForm($request, $event, $termConsentFormUrl);
            }
        }

        return $event;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\HttpKernel\Event\RequestEvent $event
     * @param string $termConsentFormUrl
     *
     * @return void
     */
    protected function handleUnfilledForm(Request $request, RequestEvent $event, string $termConsentFormUrl): void
    {
        // The parsed URL of the page the user wants to switch to
        $currentPath = $request->getPathInfo();

        if ($currentPath !== $termConsentFormUrl) {
            // Checks whether the user wants to log out or whether 'newsletter/subscribe' is being loaded from the footer organism.
            if ($this->isSpecialPath($currentPath)) {
                return;
            }

            // Extracts saved terms URLs from the session and allows to open them
            $session = $request->getSession();
            $allowedLinkUrls = $session->get('allowed_link_urls', []);
            if (in_array($currentPath, $allowedLinkUrls, true)) {
                return;
            }

            $response = new RedirectResponse($termConsentFormUrl);
            $event->setResponse($response);
        }
    }

    /**
     * @param string $refererPath
     * @param array<string> $allowedLinkUrls
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Symfony\Component\HttpKernel\Event\RequestEvent $event
     *
     * @return bool
     */
    protected function isAllowedLink(string $refererPath, array $allowedLinkUrls, Request $request, RequestEvent $event): bool
    {
        if ($allowedLinkUrls) {
            foreach ($allowedLinkUrls as $allowedLinkUrl) {
                if ($refererPath === $allowedLinkUrl) {
                    $currentPath = $request->getPathInfo();
                    if ($this->isSpecialPath($currentPath)) {
                        return true;
                    }

                    $response = new RedirectResponse($allowedLinkUrl);
                    $event->setResponse($response);

                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return string|null
     */
    protected function getRefererPath(Request $request): ?string
    {
        $referer = $request->server->get('HTTP_REFERER');
        if (!$referer) {
            return null;
        }

        return parse_url($referer, PHP_URL_PATH);
    }

    /**
     * @param \Symfony\Component\HttpKernel\Event\RequestEvent $event
     *
     * @return string
     */
    protected function createTermConsentFormParsedUrl(RequestEvent $event): string
    {
        $language = $event->getRequest()->attributes->get('language') ?? self::DEFAULT_LANGUAGE;

        return '/' . $language . '/' . CustomerPageRouteProviderPlugin::ROUTE_NAME_TERM_CONSENT;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Session\SessionInterface $session
     *
     * @return bool
     */
    protected function isFormFilled(SessionInterface $session): bool
    {
        return $session->get('form_filled', false);
    }

    /**
     * @param string $currentPath
     *
     * @return bool
     */
    protected function isSpecialPath(string $currentPath): bool
    {
        return in_array($currentPath, [self::SUBSCRIBE_URL, self::LOGIN_URL], true);
    }
}
