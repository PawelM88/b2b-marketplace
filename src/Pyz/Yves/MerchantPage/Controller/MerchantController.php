<?php

declare(strict_types=1);

namespace Pyz\Yves\MerchantPage\Controller;

use Generated\Shared\Transfer\ContactFormTransfer;
use Generated\Shared\Transfer\MerchantProfileCriteriaTransfer;
use Generated\Shared\Transfer\MerchantStorageTransfer;
use Spryker\Yves\Kernel\View\View;
use SprykerShop\Yves\MerchantPage\Controller\MerchantController as SprykerMerchantController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Yves\MerchantPage\MerchantPageFactory getFactory()
 * @method \Pyz\Client\MerchantPage\MerchantPageClientInterface getClient()
 */
class MerchantController extends SprykerMerchantController
{
    /**
     * @var string
     */
    public const CONTACT_FORM_MESSAGE_SEND = 'merchant_page.contact_form.message.send';

    /**
     * @var string
     */
    public const CONTACT_FORM_FILLED_INCORRECT = 'merchant_page.contact_form.fill.incorrect';

    /**
     * @param \Generated\Shared\Transfer\MerchantStorageTransfer $merchantStorageTransfer
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @throws \Spryker\Yves\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Spryker\Yves\Kernel\View\View
     */
    public function indexAction(MerchantStorageTransfer $merchantStorageTransfer, Request $request): View
    {
        $content = $this->executeIndexAction($merchantStorageTransfer, $request);

        return $this->view(
            $content,
            [],
            '@MerchantPage/views/merchant-page/merchant-page.twig',
        );
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantStorageTransfer $merchantStorageTransfer
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @throws \Spryker\Yves\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return array<mixed>
     */
    protected function executeIndexAction(MerchantStorageTransfer $merchantStorageTransfer, Request $request): array
    {
        $contactForm = $this
            ->getFactory()
            ->createMerchantFormFactory()
            ->getContactForm()
            ->handleRequest($request);

        $content = [
            'merchant' => $merchantStorageTransfer,
            'contactForm' => $contactForm->createView(),
        ];

        if ($contactForm->isSubmitted()) {
            if (!$contactForm->isValid()) {
                $this->addErrorMessage(static::CONTACT_FORM_FILLED_INCORRECT);

                return $content;
            }

            if ($this->processSendMessageToMerchant($contactForm->getData(), $merchantStorageTransfer) === true) {
                $this->addSuccessMessage(static::CONTACT_FORM_MESSAGE_SEND);

                return $this->renderEmptyContactForm($merchantStorageTransfer);
            }

            return $this->renderEmptyContactForm($merchantStorageTransfer);
        }

        return $content;
    }

    /**
     * @param \Generated\Shared\Transfer\MerchantStorageTransfer $merchantStorageTransfer
     *
     * @throws \Spryker\Yves\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return array<mixed>
     */
    protected function renderEmptyContactForm(MerchantStorageTransfer $merchantStorageTransfer): array
    {
        $contactForm = $this
            ->getFactory()
            ->createMerchantFormFactory()
            ->getContactForm();

        return [
            'merchant' => $merchantStorageTransfer,
            'contactForm' => $contactForm->createView(),
        ];
    }

    /**
     * @param array<mixed> $messageData
     * @param \Generated\Shared\Transfer\MerchantStorageTransfer $merchantStorageTransfer
     *
     * @return bool
     */
    protected function processSendMessageToMerchant(array $messageData, MerchantStorageTransfer $merchantStorageTransfer): bool
    {
        $contactFormTransfer = new ContactFormTransfer();
        $contactFormTransfer->fromArray($messageData);
        $contactFormTransfer->setMerchantEmail($merchantStorageTransfer->getMerchantProfile()->getPublicEmail());
        $contactFormTransfer->setMerchantName($merchantStorageTransfer->getName());

        $contactFormTransfer->setMerchantProfileCriteria((new MerchantProfileCriteriaTransfer())
            ->setMerchantReference($merchantStorageTransfer->getMerchantReference()));

        $contactFormResponseTransfer = $this->getClient()
            ->sendMessageToMerchant($contactFormTransfer);

        if ($contactFormResponseTransfer->getIsSuccess()) {
            return true;
        }

        $this->addErrorMessage($contactFormResponseTransfer->getErrorMessage());

        return false;
    }
}
