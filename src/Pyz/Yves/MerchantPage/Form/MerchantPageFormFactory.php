<?php

declare(strict_types=1);

namespace Pyz\Yves\MerchantPage\Form;

use Spryker\Shared\Application\ApplicationConstants;
use Spryker\Yves\Kernel\AbstractFactory;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;

class MerchantPageFormFactory extends AbstractFactory
{
    /**
     * @throws \Spryker\Yves\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Symfony\Component\Form\FormFactory
     */
    public function getFormFactory(): FormFactory
    {
        return $this->getProvidedDependency(ApplicationConstants::FORM_FACTORY);
    }

    /**
     * @throws \Spryker\Yves\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getContactForm(): FormInterface
    {
        return $this->getFormFactory()->create(ContactForm::class);
    }
}
