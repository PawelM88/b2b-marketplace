<?php

declare(strict_types=1);

namespace Pyz\Zed\MerchantPaymentCommissionGui\Communication\Form;

use Generated\Shared\Transfer\MerchantPaymentCommissionTransfer;
use Pyz\Zed\MerchantPaymentCommissionGui\Communication\Form\MerchantPaymentCommissionSubforms\MerchantPaymentCommissionPerStoreFormType;
use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @method \Pyz\Zed\MerchantPaymentCommissionGui\Communication\MerchantPaymentCommissionGuiCommunicationFactory getFactory()
 */
class MerchantPaymentCommissionForm extends AbstractType
{
    /**
     * @var string
     */
    protected const FIELD_PAYMENT_COMMISSION_KEY = 'gr_payment_commission_key';

    /**
     * @var string
     */
    protected const FIELD_PAYMENT_COMMISSION_CAP_KEY = 'gr_payment_commission_cap_key';

    /**
     * @var string
     */
    protected const FIELD_MERCHANT_PAYMENT_COMMISSION_PER_STORE = 'merchantPaymentCommissionPerStore';

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return 'payment commission';
    }

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);
        $resolver->setDefaults([
            'data_class' => MerchantPaymentCommissionTransfer::class,
        ]);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array<string, mixed> $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->addMerchantPaymentCommissionKeyField($builder)
            ->addMerchantPaymentCommissionCapKeyField($builder)
            ->addMerchantPaymentCommissionPerStoreForm($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addMerchantPaymentCommissionKeyField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_PAYMENT_COMMISSION_KEY, HiddenType::class);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addMerchantPaymentCommissionCapKeyField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_PAYMENT_COMMISSION_CAP_KEY, HiddenType::class);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addMerchantPaymentCommissionPerStoreForm(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_MERCHANT_PAYMENT_COMMISSION_PER_STORE, CollectionType::class, [
            'label' => false,
            'entry_type' => MerchantPaymentCommissionPerStoreFormType::class,
        ]);

        return $this;
    }
}
