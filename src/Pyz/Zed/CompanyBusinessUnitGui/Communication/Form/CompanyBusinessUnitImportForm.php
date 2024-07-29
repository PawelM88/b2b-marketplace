<?php

declare(strict_types=1);

namespace Pyz\Zed\CompanyBusinessUnitGui\Communication\Form;

use Pyz\Zed\CompanyBusinessUnitGui\Communication\File\UploadedFile;
use Spryker\Zed\Kernel\Communication\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile as SymfonyUploadedFile;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

/**
 * @method \Pyz\Zed\CompanyBusinessUnitGui\CompanyBusinessUnitGuiConfig getConfig()
 * @method \Spryker\Zed\CompanyBusinessUnitGui\Business\CompanyBusinessUnitGuiFacadeInterface getFacade()
 * @method \Pyz\Zed\CompanyBusinessUnitGui\Communication\CompanyBusinessUnitGuiCommunicationFactory getFactory()
 */
class CompanyBusinessUnitImportForm extends AbstractType
{
    /**
     * @var string
     */
    public const FIELD_FILE_UPLOAD = 'fileUpload';

    /**
     * @var string
     */
    public const BLOCK_PREFIX = 'companyBusinessUnitImport';

    /**
     * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
     *
     * @return void
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'label' => false,
        ]);
    }

    /**
     * @return string
     */
    public function getBlockPrefix(): string
    {
        return static::BLOCK_PREFIX;
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     * @param array<string, mixed> $options
     *
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $this->addUploadFileField($builder);
    }

    /**
     * @param \Symfony\Component\Form\FormBuilderInterface $builder
     *
     * @return void
     */
    protected function addUploadFileField(FormBuilderInterface $builder): void
    {
        $builder->add(static::FIELD_FILE_UPLOAD, FileType::class, [
            'label' => 'Select file with company business units to import',
            'required' => true,
            'attr' => [
                'accept' => implode(',', $this->getConfig()->getFileMimeTypes()),
            ],
            'constraints' => [
                new File([
                    'maxSize' => $this->getConfig()->getMaxFileSize(),
                    'mimeTypes' => $this->getConfig()->getFileMimeTypes(),
                ]),
            ],
        ]);

        $builder->get(static::FIELD_FILE_UPLOAD)
            ->addModelTransformer(
                new CallbackTransformer(
                    function ($data) {
                        return $data;
                    },
                    function (?SymfonyUploadedFile $uploadedFile = null) {
                        if ($uploadedFile === null) {
                            return $uploadedFile;
                        }

                        return $this->mapSymfonyUploadedFileToUploadedFile($uploadedFile);
                    },
                ),
            );
    }

    /**
     * @param \Symfony\Component\HttpFoundation\File\UploadedFile $uploadedFile
     *
     * @return \Pyz\Zed\CompanyBusinessUnitGui\Communication\File\UploadedFile
     */
    protected function mapSymfonyUploadedFileToUploadedFile(SymfonyUploadedFile $uploadedFile): UploadedFile
    {
        /** @var string $path */
        $path = $uploadedFile->getRealPath();

        return new UploadedFile(
            $path,
            $uploadedFile->getClientOriginalName(),
            $uploadedFile->getClientMimeType(),
            $uploadedFile->getSize(),
        );
    }
}
