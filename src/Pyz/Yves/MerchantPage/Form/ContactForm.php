<?php

declare(strict_types=1);

namespace Pyz\Yves\MerchantPage\Form;

use Pyz\Yves\MerchantPage\MerchantPageConfig;
use Spryker\Yves\Kernel\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

/**
 * @method \Pyz\Yves\MerchantPage\MerchantPageConfig getConfig()
 * @method \Pyz\Yves\MerchantPage\Form\MerchantPageFormFactory getFactory()
 */
class ContactForm extends AbstractType
{
    /**
     * @var string
     */
    public const FIELD_SALUTATION = 'salutation';

    /**
     * @var string
     */
    public const FIELD_FIRST_NAME = 'first_name';

    /**
     * @var string
     */
    public const FIELD_LAST_NAME = 'last_name';

    /**
     * @var string
     */
    public const FIELD_PHONE_NUMBER = 'phone_number';

    /**
     * @var string
     */
    public const FIELD_EMAIL = 'email';

    /**
     * @var string
     */
    public const FIELD_SUBJECT = 'subject';

    /**
     * @var string
     */
    public const FIELD_TEXTAREA = 'message';

    /**
     * @var string
     */
    public const PLACEHOLDER_PHONE_NUMBER = 'merchant_page.contact_form.placeholder.phone_number';

    /**
     * @var string
     */
    protected const VALIDATION_NOT_BLANK_MESSAGE = 'validation.not_blank';

    /**
     * @var string
     */
    protected const VALIDATION_LETTERS = 'validation.letters';

    /**
     * @var string
     */
    protected const VALIDATION_NUMBERS = 'validation.numbers';

    /**
     * @var string
     */
    protected const VALIDATION_SUBJECT = 'validation.subject';

    /**
     * @var string
     */
    protected const VALIDATION_EMAIL_MESSAGE = 'validation.email';

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return 'contactForm';
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array<string, mixed> $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this
            ->addSalutationField($builder)
            ->addFirstNameField($builder)
            ->addLastNameField($builder)
            ->addPhoneNumberField($builder)
            ->addEmailField($builder)
            ->addSubjectField($builder)
            ->addTextAreaField($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    public function addSalutationField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_SALUTATION, ChoiceType::class, [
            'choices' => array_flip([
                'Mr' => 'merchant_page.contact_form.salutation.mr',
                'Ms' => 'merchant_page.contact_form.salutation.ms',
                'Mrs' => 'merchant_page.contact_form.salutation.mrs',
                'Dr' => 'merchant_page.contact_form.salutation.dr',
            ]),
            'label' => 'merchant_page.contact_form.salutation',
            'required' => true,
            'constraints' => [
                $this->createNotBlankConstraint(),
            ],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    public function addFirstNameField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_FIRST_NAME, TextType::class, [
            'label' => 'merchant_page.contact_form.first_name',
            'required' => true,
            'constraints' => [
                $this->createNotBlankConstraint(),
                $this->createFirstNameRegexConstraint(),
            ],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    public function addLastNameField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_LAST_NAME, TextType::class, [
            'label' => 'merchant_page.contact_form.last_name',
            'required' => true,
            'constraints' => [
                $this->createNotBlankConstraint(),
                $this->createLastNameRegexConstraint(),
            ],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    public function addPhoneNumberField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_PHONE_NUMBER, TelType::class, [
            'label' => 'merchant_page.contact_form.phone',
            'attr' => [
                'placeholder' => static::PLACEHOLDER_PHONE_NUMBER,
            ],
            'required' => false,
            'trim' => true,
            'sanitize_xss' => true,
            'constraints' => [
                $this->createPhoneNumberRegexConstraint(),
            ],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    public function addEmailField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_EMAIL, EmailType::class, [
            'label' => 'merchant_page.contact_form.email',
            'required' => true,
            'sanitize_xss' => true,
            'constraints' => [
                $this->createNotBlankConstraint(),
                $this->createEmailConstraint(),
            ],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    public function addSubjectField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_SUBJECT, TextType::class, [
            'label' => 'merchant_page.contact_form.subject',
            'required' => true,
            'constraints' => [
                $this->createNotBlankConstraint(),
                $this->createSubjectRegexConstraint(),
            ],
        ]);

        return $this;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return $this
     */
    public function addTextAreaField(FormBuilderInterface $builder)
    {
        $builder->add(static::FIELD_TEXTAREA, TextareaType::class, [
            'label' => 'merchant_page.contact_form.textarea',
            'required' => true,
            'constraints' => [
                $this->createNotBlankConstraint(),
            ],
        ]);

        return $this;
    }

    /**
     * @return \Symfony\Component\Validator\Constraints\NotBlank
     */
    protected function createNotBlankConstraint(): NotBlank
    {
        return new NotBlank(['message' => static::VALIDATION_NOT_BLANK_MESSAGE]);
    }

    /**
     * @return \Symfony\Component\Validator\Constraints\Regex
     */
    protected function createFirstNameRegexConstraint(): Regex
    {
        return new Regex([
            'pattern' => MerchantPageConfig::PATTERN_FIRST_NAME,
            'message' => static::VALIDATION_LETTERS,
        ]);
    }

    /**
     * @return \Symfony\Component\Validator\Constraints\Regex
     */
    protected function createLastNameRegexConstraint(): Regex
    {
        return new Regex([
            'pattern' => MerchantPageConfig::PATTERN_LAST_NAME,
            'message' => static::VALIDATION_LETTERS,
        ]);
    }

    /**
     * @return \Symfony\Component\Validator\Constraints\Regex
     */
    public function createPhoneNumberRegexConstraint(): Regex
    {
        return new Regex([
            'pattern' => MerchantPageConfig::PATTERN_PHONE_NUMBER,
            'message' => static::VALIDATION_NUMBERS,
        ]);
    }

    /**
     * @return \Symfony\Component\Validator\Constraints\Email
     */
    protected function createEmailConstraint(): Email
    {
        return new Email(['message' => static::VALIDATION_EMAIL_MESSAGE]);
    }

    /**
     * @return \Symfony\Component\Validator\Constraints\Regex
     */
    protected function createSubjectRegexConstraint(): Regex
    {
        return new Regex([
            'pattern' => MerchantPageConfig::PATTERN_SUBJECT,
            'message' => static::VALIDATION_SUBJECT,
        ]);
    }
}
