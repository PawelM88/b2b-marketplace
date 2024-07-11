<?php

declare(strict_types=1);

namespace Pyz\Yves\CustomerPage\Form;

use Spryker\Yves\Kernel\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @method \Pyz\Yves\CustomerPage\CustomerPageConfig getConfig()
 */
class TermConsentForm extends AbstractType
{
    /**
     * @var string
     */
    public const FORM_NAME = 'termConsentForm';

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return static::FORM_NAME;
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
            'terms' => [],
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
        foreach ($options['terms'] as $term) {
            $builder->add($term->getTermKey(), CheckboxType::class, [
                'allow_extra_fields' => ['idTerm' => $term->getIdTerm()],
                'label' => $term->getTermName(),
                'attr' => [
                    'url' => $term->getTermUrl(),
                ],
                'required' => true,
                'mapped' => false,
            ]);
        }
    }
}
