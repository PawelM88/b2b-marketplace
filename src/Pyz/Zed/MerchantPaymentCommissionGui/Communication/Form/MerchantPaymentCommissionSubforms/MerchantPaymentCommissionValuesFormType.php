<?php

declare(strict_types=1);

namespace Pyz\Zed\MerchantPaymentCommissionGui\Communication\Form\MerchantPaymentCommissionSubforms;

use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\Type;

/**
 * @method \Pyz\Zed\MerchantPaymentCommissionGui\Communication\MerchantPaymentCommissionGuiCommunicationFactory getFactory()
 */
class MerchantPaymentCommissionValuesFormType extends AbstractType
{
    /**
     * @var string
     */
    protected const FIELD_PAYMENT_COMMISSION = 'grPaymentCommissionKey';

    /**
     * @var string
     */
    protected const FIELD_PAYMENT_COMMISSION_CAP = 'grPaymentCommissionCapKey';

    /**
     * @var string
     */
    protected const LABEL_PAYMENT_COMMISSION = 'Payment Commission';

    /**
     * @var string
     */
    protected const LABEL_PAYMENT_COMMISSION_CAP = 'Payment Commission Cap';

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array<string, mixed> $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->addPaymentCommissionField($builder)
            ->addPaymentCommissionCapField($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addPaymentCommissionField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_PAYMENT_COMMISSION, IntegerType::class, [
            'label' => static::LABEL_PAYMENT_COMMISSION,
            'constraints' => [
                new Type([
                    'type' => 'integer',
                    'message' => 'The value {{ value }} is not a valid {{ type }}',
                ]),
                new LessThanOrEqual([
                    'value' => 100,
                    'message' => 'This value should be less than or equal to {{ compared_value }}',
                ]),
                new GreaterThanOrEqual([
                    'value' => 0,
                    'message' => 'This value should be greater than or equal to {{ compared_value }}',
                ]),
            ],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addPaymentCommissionCapField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_PAYMENT_COMMISSION_CAP, IntegerType::class, [
            'label' => static::LABEL_PAYMENT_COMMISSION_CAP,
            'constraints' => [
                new Type([
                    'type' => 'integer',
                    'message' => 'The value {{ value }} is not a valid {{ type }}',
                ]),
                new LessThanOrEqual([
                    'value' => 2147483647,
                    'message' => 'This value should be less than or equal to {{ compared_value }}',
                ]),
                new GreaterThanOrEqual([
                    'value' => 0,
                    'message' => 'This value should be greater than or equal to {{ compared_value }}',
                ]),
            ],
        ]);

        return $this;
    }
}
