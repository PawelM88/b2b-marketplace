<?php

declare(strict_types=1);

namespace Pyz\Zed\MerchantPaymentCommissionGui\Communication\Form\MerchantPaymentCommissionSubforms;

use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @method \Pyz\Zed\MerchantPaymentCommissionGui\Communication\MerchantPaymentCommissionGuiCommunicationFactory getFactory()
 */
class MerchantPaymentCommissionPerStoreFormType extends AbstractType
{
    /**
     * @var string
     */
    protected const FIELD_MERCHANT_PAYMENT_COMMISSION_VALUES = 'merchantPaymentCommissionValues';

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array<string, mixed> $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->addMerchantPaymentCommissionPerStoreForm($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addMerchantPaymentCommissionPerStoreForm(FormBuilderInterface $builder)
    {
        $builder->add(
            static::FIELD_MERCHANT_PAYMENT_COMMISSION_VALUES,
            MerchantPaymentCommissionValuesFormType::class,
            [
                'label' => false,
            ],
        );

        return $this;
    }
}
