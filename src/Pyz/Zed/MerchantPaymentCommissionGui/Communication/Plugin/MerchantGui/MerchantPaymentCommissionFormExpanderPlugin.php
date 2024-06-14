<?php

declare(strict_types=1);

namespace Pyz\Zed\MerchantPaymentCommissionGui\Communication\Plugin\MerchantGui;

use Pyz\Zed\MerchantPaymentCommissionGui\Communication\Form\MerchantPaymentCommissionForm;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\MerchantGuiExtension\Dependency\Plugin\MerchantFormExpanderPluginInterface;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @method \Pyz\Zed\MerchantPaymentCommissionGui\Communication\MerchantPaymentCommissionGuiCommunicationFactory getFactory()
 * @method \Pyz\Zed\MerchantPaymentCommission\Business\MerchantPaymentCommissionFacadeInterface getFacade()
 */
class MerchantPaymentCommissionFormExpanderPlugin extends AbstractPlugin implements MerchantFormExpanderPluginInterface
{
    /**
     * @var string
     */
    protected const FIELD_MERCHANT_PAYMENT_COMMISSION = 'merchantPaymentCommission';

    /**
     * {@inheritDoc}
     *
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array<string, mixed> $options
     *
     * @return \Symfony\Component\Form\FormBuilderInterface
     */
    public function expand(FormBuilderInterface $builder, array $options): FormBuilderInterface
    {
        $this->addMerchantPaymentCommissionFieldSubform($builder);

        return $builder;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    protected function addMerchantPaymentCommissionFieldSubform(FormBuilderInterface $builder)
    {
        $options = $this->getMerchantPaymentCommissionFormOptions($builder);
        $builder->add(
            static::FIELD_MERCHANT_PAYMENT_COMMISSION,
            MerchantPaymentCommissionForm::class,
            $options,
        );

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return array <mixed>
     */
    protected function getMerchantPaymentCommissionFormOptions(FormBuilderInterface $builder): array
    {
        $merchantPaymentCommissionDataProvider = $this->getFactory()
            ->createMerchantPaymentCommissionFormDataProvider();

        /** @var \Generated\Shared\Transfer\MerchantTransfer $merchantTransfer */
        $merchantTransfer = $builder->getForm()->getData();
        $options = [
            'data' => $merchantPaymentCommissionDataProvider->getData(
                $merchantTransfer->getMerchantPaymentCommission(),
            ),
        ];

        return $options;
    }
}
