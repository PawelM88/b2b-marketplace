<?php

declare(strict_types=1);

namespace Pyz\Yves\CustomerPage\Form;

use SprykerShop\Yves\CustomerPage\Form\FormFactory as SprykerFormFactory;
use Symfony\Component\Form\FormInterface;

class FormFactory extends SprykerFormFactory
{
    /**
     * @param array<mixed> $terms
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    public function getTermConsentForm(array $terms): FormInterface
    {
        return $this->getFormFactory()->create(TermConsentForm::class, null, ['terms' => $terms]);
    }
}
