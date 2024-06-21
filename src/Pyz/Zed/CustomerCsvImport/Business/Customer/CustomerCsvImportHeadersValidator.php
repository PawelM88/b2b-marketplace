<?php

declare(strict_types=1);

namespace Pyz\Zed\CustomerCsvImport\Business\Customer;

use Generated\Shared\Transfer\CustomerCsvValidationResultTransfer;
use Pyz\Zed\Customer\Communication\File\UploadedFile;
use Pyz\Zed\CustomerCsvImport\CustomerCsvImportConfig;
use Spryker\Service\UtilCsv\UtilCsvServiceInterface;

class CustomerCsvImportHeadersValidator implements CustomerCsvImportHeadersValidatorInterface
{
    /**
     * @var string
     */
    protected const ERROR_HEADERS_MISSING = '%s header(s) is missing in uploaded file.';

    /**
     * @param \Spryker\Service\UtilCsv\UtilCsvServiceInterface $csvService
     * @param \Pyz\Zed\CustomerCsvImport\CustomerCsvImportConfig $productConfig
     */
    public function __construct(
        protected UtilCsvServiceInterface $csvService,
        protected CustomerCsvImportConfig $productConfig,
    ) {
    }

    /**
     * @param \Pyz\Zed\Customer\Communication\File\UploadedFile $uploadedFile
     *
     * @return \Generated\Shared\Transfer\CustomerCsvValidationResultTransfer
     */
    public function validateCsvFile(UploadedFile $uploadedFile): CustomerCsvValidationResultTransfer
    {
        $customerCsvValidationResultTransfer = (new CustomerCsvValidationResultTransfer())->setIsSuccess(false);
        $importItems = $this->csvService->readUploadedFile($uploadedFile);

        $headers = current($importItems);
        $expectedHeaders = $this->productConfig->getFieldsList();
        $missingHeaders = array_diff($expectedHeaders, $headers);

        if (count($missingHeaders) === 0) {
            return $customerCsvValidationResultTransfer->setIsSuccess(true);
        }

        return $customerCsvValidationResultTransfer->setError(
            sprintf(static::ERROR_HEADERS_MISSING, implode(', ', $missingHeaders)),
        );
    }
}
