<?php

declare(strict_types=1);

namespace Pyz\Zed\CompanyBusinessUnitCsvImport\Business\CompanyBusinessUnit;

use Generated\Shared\Transfer\CompanyBusinessUnitCsvValidationResultTransfer;
use Pyz\Zed\CompanyBusinessUnitCsvImport\CompanyBusinessUnitCsvImportConfig;
use Pyz\Zed\CompanyBusinessUnitGui\Communication\File\UploadedFile;
use Spryker\Service\UtilCsv\UtilCsvServiceInterface;

class CompanyBusinessUnitCsvImportHeadersValidator implements CompanyBusinessUnitCsvImportHeadersValidatorInterface
{
    /**
     * @var string
     */
    protected const ERROR_HEADERS_MISSING = '%s header(s) is missing in uploaded file.';

    /**
     * @param \Spryker\Service\UtilCsv\UtilCsvServiceInterface $csvService
     * @param \Pyz\Zed\CompanyBusinessUnitCsvImport\CompanyBusinessUnitCsvImportConfig $companyBusinessUnitCsvImportConfig
     */
    public function __construct(
        protected UtilCsvServiceInterface $csvService,
        protected CompanyBusinessUnitCsvImportConfig $companyBusinessUnitCsvImportConfig,
    ) {
    }

    /**
     * @param \Pyz\Zed\CompanyBusinessUnitGui\Communication\File\UploadedFile $uploadedFile
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitCsvValidationResultTransfer
     */
    public function validateCsvFile(UploadedFile $uploadedFile): CompanyBusinessUnitCsvValidationResultTransfer
    {
        $companyBusinessUnitCsvValidationResultTransfer = (new CompanyBusinessUnitCsvValidationResultTransfer())->setIsSuccess(false);
        $importItems = $this->csvService->readUploadedFile($uploadedFile);

        $headers = current($importItems);
        $expectedHeaders = $this->companyBusinessUnitCsvImportConfig->getFieldsList();
        $missingHeaders = array_diff($expectedHeaders, $headers);

        if (count($missingHeaders) === 0) {
            return $companyBusinessUnitCsvValidationResultTransfer->setIsSuccess(true);
        }

        return $companyBusinessUnitCsvValidationResultTransfer->setError(
            sprintf(static::ERROR_HEADERS_MISSING, implode(', ', $missingHeaders)),
        );
    }
}
