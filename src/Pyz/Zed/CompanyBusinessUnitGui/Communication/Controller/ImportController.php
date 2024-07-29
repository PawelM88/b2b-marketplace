<?php

declare(strict_types=1);

namespace Pyz\Zed\CompanyBusinessUnitGui\Communication\Controller;

use Generated\Shared\Transfer\CompanyBusinessUnitCsvValidationResultTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitImportTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitListImportRequestTransfer;
use Generated\Shared\Transfer\CompanyBusinessUnitListImportResponseTransfer;
use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\ImportStatisticTransfer;
use Generated\Shared\Transfer\MessageTransfer;
use Pyz\Zed\CompanyBusinessUnitGui\Communication\Form\CompanyBusinessUnitImportForm;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Zed\CompanyBusinessUnitGui\Communication\CompanyBusinessUnitGuiCommunicationFactory getFactory()
 * @method \Spryker\Zed\CompanyBusinessUnitGui\Business\CompanyBusinessUnitGuiFacadeInterface getFacade()
 */
class ImportController extends AbstractController
{
    /**
     * @var string
     */
    protected const URL_BUSINESS_UNIT_LIST = '/company-business-unit-gui/list-company-business-unit';

    /**
     * @var string
     */
    protected const URL_BUSINESS_UNIT_IMPORT = '/company-business-unit-gui/import';

    /**
     * @var string
     */
    protected const MESSAGE_SUCCESS_COMPANY_BUSINESS_UNIT_IMPORT = 'Company Business Units have been imported';

    /**
     * @return array<string, mixed>
     */
    public function indexAction(): array
    {
        $companyBusinessUnitImportForm = $this->getFactory()->getCompanyBusinessUnitImportForm();

        return $this->viewResponse([
            'importForm' => $companyBusinessUnitImportForm->createView(),
            'backCompanyBusinessUnitListButton' => static::URL_BUSINESS_UNIT_LIST,
        ]);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array<string, mixed>
     */
    public function uploadAction(Request $request): RedirectResponse|array
    {
        $companyBusinessUnitImportForm = $this->getFactory()->getCompanyBusinessUnitImportForm();
        $companyBusinessUnitImportForm->handleRequest($request);

        $companyBusinessUnitCsvValidationResultTransfer = $this->validateCompanyBusinessUnitImportForm(
            $companyBusinessUnitImportForm
        );

        if ($companyBusinessUnitCsvValidationResultTransfer->getIsSuccess() === false) {
            $this->addErrorMessage($companyBusinessUnitCsvValidationResultTransfer->getError());

            return $this->redirectResponse(static::URL_BUSINESS_UNIT_IMPORT);
        }

        return $this->prepareIndexData($companyBusinessUnitImportForm);
    }

    /**
     * @param \Symfony\Component\Form\FormInterface $companyBusinessUnitImportForm
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitCsvValidationResultTransfer
     */
    protected function validateCompanyBusinessUnitImportForm(FormInterface $companyBusinessUnitImportForm
    ): CompanyBusinessUnitCsvValidationResultTransfer {
        $uploadedFileData = $companyBusinessUnitImportForm
            ->get(CompanyBusinessUnitImportForm::FIELD_FILE_UPLOAD)
            ->getData();

        return $this->getFactory()
            ->getCompanyBusinessUnitCsvImporterFacade()
            ->validateCsvFile($uploadedFileData);
    }

    /**
     * @param \Symfony\Component\Form\FormInterface $companyBusinessUnitImportForm
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return array<string, mixed>
     */
    protected function prepareIndexData(FormInterface $companyBusinessUnitImportForm): array
    {
        $companyBusinessUnitListImportResponseTransfer = $this->handleCompanyBusinessUnitImportForm(
            $companyBusinessUnitImportForm
        );
        $companyBusinessUnitListImportRequestTransfer = $companyBusinessUnitListImportResponseTransfer->getCompanyBusinessUnitListImportRequest(
        );

        $errorTable = $this->getFactory()->createImportErrorTable($companyBusinessUnitListImportResponseTransfer);
        $errorTableData = $this->getFactory()
            ->createTableFormatter()
            ->formatAbstractTableToArray($errorTable);

        $importStatisticTransfer = null;

        if (empty($errorTableData['data'])) {
            $importStatisticTransfer = $this->saveCompanyBusinessUnitCsvData(
                $companyBusinessUnitListImportRequestTransfer
            );

            $this->addSuccessMessage(static::MESSAGE_SUCCESS_COMPANY_BUSINESS_UNIT_IMPORT);
        }

        return $this->viewResponse([
            'importForm' => $companyBusinessUnitImportForm->createView(),
            'backCompanyBusinessUnitListButton' => static::URL_BUSINESS_UNIT_LIST,
            'backCompanyBusinessUnitImportButton' => static::URL_BUSINESS_UNIT_IMPORT,
            'errorTable' => $errorTableData,
            'importStatistic' => $importStatisticTransfer,
        ]);
    }

    /**
     * @param \Symfony\Component\Form\FormInterface $importForm
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Generated\Shared\Transfer\CompanyBusinessUnitListImportResponseTransfer
     */
    protected function handleCompanyBusinessUnitImportForm(
        FormInterface $importForm,
    ): CompanyBusinessUnitListImportResponseTransfer {
        $uploadedFile = $importForm
            ->get(CompanyBusinessUnitImportForm::FIELD_FILE_UPLOAD)
            ->getData();

        $companyBusinessUnitListImportRequestTransfer = new CompanyBusinessUnitListImportRequestTransfer();

        $companyBusinessUnitListImportRequestTransfer = $this->getFactory()
            ->getCompanyBusinessUnitCsvImporterFacade()
            ->readCompanyBusinessUnitImportTransfersFromCsvFile(
                $uploadedFile,
                $companyBusinessUnitListImportRequestTransfer
            );

        return $this->getFactory()
            ->getCompanyBusinessUnitCsvImporterFacade()
            ->validateCompanyBusinessUnitCsvData($companyBusinessUnitListImportRequestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitListImportRequestTransfer $companyBusinessUnitListImportRequestTransfer
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Generated\Shared\Transfer\ImportStatisticTransfer
     */
    private function saveCompanyBusinessUnitCsvData(
        CompanyBusinessUnitListImportRequestTransfer $companyBusinessUnitListImportRequestTransfer
    ): ImportStatisticTransfer {
        $importStatisticTransfer = new ImportStatisticTransfer();

        foreach ($companyBusinessUnitListImportRequestTransfer->getItems() as $companyBusinessUnitImportTransfer) {
            $companyTransfer = $this->processCompanyBusinessUnitData($companyBusinessUnitImportTransfer);
            $customerTransfer = $this->processCustomerData($companyBusinessUnitImportTransfer);

            $importStatisticTransfer = $this->updateImportStatistics($importStatisticTransfer, $companyTransfer, $customerTransfer);

            $mappedCompanyUser = $this->getFactory()->getCompanyBusinessUnitCsvImporterFacade(
            )->mapCustomerAndCompanyDataToCompanyUser(
                $customerTransfer,
                $companyTransfer,
                $companyBusinessUnitImportTransfer->getCompanyBusinessUnit()
            );

            $this->getFactory()->getCompanyUserFacade()->create($mappedCompanyUser);
        }

        return $importStatisticTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitImportTransfer $companyBusinessUnitImportTransfer
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer
     */
    private function processCompanyBusinessUnitData(
        CompanyBusinessUnitImportTransfer $companyBusinessUnitImportTransfer
    ): CompanyTransfer {
        $companyFacade = $this->getFactory()->getPyzCompanyFacade();
        $companyBusinessUnitCsvImporterFacade = $this->getFactory()->getCompanyBusinessUnitCsvImporterFacade();
        $companyBusinessUnitFacade = $this->getFactory()->getPyzCompanyBusinessUnitFacade();
        $companyUnitAddressFacade = $this->getFactory()->getCompanyUnitAddressFacade();

        $companyTransfer = $companyFacade->createCompanyBasedOnDataFromCombinedCsvFile(
            $companyBusinessUnitImportTransfer->getCompany()
        );

        $mappedCompanyBusinessUnitTransfer = $companyBusinessUnitCsvImporterFacade->mapCompanyToCompanyBusinessUnit(
            $companyTransfer,
            $companyBusinessUnitImportTransfer->getCompanyBusinessUnit()
        );
        $companyBusinessUnitTransfer = $companyBusinessUnitFacade->createCompanyBusinessUnitBasedOnDataFromCombinedCsvFile(
            $mappedCompanyBusinessUnitTransfer
        );

        $companyTransfer->setCompanyBusinessUnit($companyBusinessUnitTransfer);

        $mappedCompanyUnitAddress = $companyBusinessUnitCsvImporterFacade->mapCompanyToCompanyUnitAddress(
            $companyTransfer,
            $companyBusinessUnitImportTransfer->getCompanyUnitAddress()
        );
        $companyUnitAddressTransfer = $companyUnitAddressFacade->createCompanyUnitAddressBasedOnDataFromCombinedCsvFile(
            $mappedCompanyUnitAddress
        );

        $companyTransfer->setCompanyUnitAddress($companyUnitAddressTransfer);

        $spyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer = $companyBusinessUnitCsvImporterFacade->mapCompanyBusinessUnitAndCompanyUnitAddressToCompanyBusinessUnitAddress(
            $companyBusinessUnitTransfer,
            $companyUnitAddressTransfer
        );
        $companyUnitAddressFacade->saveAddressToBusinessUnitRelationFromCombinedCsvFile(
            $spyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer
        );

        return $companyTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CompanyBusinessUnitImportTransfer $companyBusinessUnitImportTransfer
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    private function processCustomerData(
        CompanyBusinessUnitImportTransfer $companyBusinessUnitImportTransfer
    ): CustomerTransfer {
        $customerFacade = $this->getFactory()->getCustomerFacade();

        $customerResponseTransfer = $customerFacade->createCustomer($companyBusinessUnitImportTransfer->getCustomer());

        if ($customerResponseTransfer->getCustomerTransfer()->getIsNew()) {
            $customerFacade->sendPasswordRestoreMail($companyBusinessUnitImportTransfer->getCustomer());
        }

        return $customerResponseTransfer->getCustomerTransfer();
    }

    /**
     * @param \Generated\Shared\Transfer\ImportStatisticTransfer $importStatisticTransfer
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\ImportStatisticTransfer
     */
    private function updateImportStatistics(
        ImportStatisticTransfer $importStatisticTransfer,
        CompanyTransfer $companyTransfer,
        CustomerTransfer $customerTransfer
    ): ImportStatisticTransfer {
        $importStatisticTransfer = $this->updateCompanyBusinessUnitStatistics($importStatisticTransfer, $companyTransfer);
        $importStatisticTransfer = $this->updateCompanyUnitAddressStatistics($importStatisticTransfer, $companyTransfer);
        $importStatisticTransfer = $this->updateCustomerStatistics($importStatisticTransfer, $customerTransfer);

        return $importStatisticTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ImportStatisticTransfer $importStatisticTransfer
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\ImportStatisticTransfer
     */
    private function updateCompanyBusinessUnitStatistics(
        ImportStatisticTransfer $importStatisticTransfer,
        CompanyTransfer $companyTransfer
    ): ImportStatisticTransfer {
        $companyBusinessUnitTransfer = $companyTransfer->getCompanyBusinessUnit();

        $currentNewCompanyBusinessUnit = $importStatisticTransfer->getNewCompanyBusinessUnit() ?? 0;
        $currentUpdatedCompanyBusinessUnit = $importStatisticTransfer->getUpdatedCompanyBusinessUnit() ?? 0;

        $newCompanyBusinessUnit = $currentNewCompanyBusinessUnit;
        $updatedCompanyBusinessUnit = $currentUpdatedCompanyBusinessUnit;

        if ($companyBusinessUnitTransfer->getIsNew() === true) {
            $newCompanyBusinessUnit++;
        }

        if ($companyBusinessUnitTransfer->getIsNew() !== true && $companyBusinessUnitTransfer->getIsUpdated() === true) {
            $updatedCompanyBusinessUnit++;
        }

        $importStatisticTransfer->setNewCompanyBusinessUnit($newCompanyBusinessUnit);
        $importStatisticTransfer->setUpdatedCompanyBusinessUnit($updatedCompanyBusinessUnit);

        return $importStatisticTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ImportStatisticTransfer $importStatisticTransfer
     * @param \Generated\Shared\Transfer\CompanyTransfer $companyTransfer
     *
     * @return \Generated\Shared\Transfer\ImportStatisticTransfer
     */
    private function updateCompanyUnitAddressStatistics(
        ImportStatisticTransfer $importStatisticTransfer,
        CompanyTransfer $companyTransfer
    ): ImportStatisticTransfer {
        $companyUnitAddressTransfer = $companyTransfer->getCompanyUnitAddress();

        $currentNewCompanyUnitAddress = $importStatisticTransfer->getNewCompanyUnitAddress() ?? 0;
        $currentUpdatedCompanyUnitAddress = $importStatisticTransfer->getUpdatedCompanyUnitAddress() ?? 0;

        $newCompanyUnitAddress = $currentNewCompanyUnitAddress;
        $updatedCompanyUnitAddress = $currentUpdatedCompanyUnitAddress;

        if ($companyUnitAddressTransfer->getIsNew() === true) {
            $newCompanyUnitAddress++;
        }

        if ($companyUnitAddressTransfer->getIsNew() !== true && $companyUnitAddressTransfer->getIsUpdated() === true) {
            $updatedCompanyUnitAddress++;
        }

        $importStatisticTransfer->setNewCompanyUnitAddress($newCompanyUnitAddress);
        $importStatisticTransfer->setUpdatedCompanyUnitAddress($updatedCompanyUnitAddress);

        return $importStatisticTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ImportStatisticTransfer $importStatisticTransfer
     * @param \Generated\Shared\Transfer\CustomerTransfer $customerTransfer
     *
     * @return \Generated\Shared\Transfer\ImportStatisticTransfer
     */
    private function updateCustomerStatistics(
        ImportStatisticTransfer $importStatisticTransfer,
        CustomerTransfer $customerTransfer
    ): ImportStatisticTransfer {
        $currentNewAdmin = $importStatisticTransfer->getNewAdmin() ?? 0;
        $currentUpdatedAdmin = $importStatisticTransfer->getUpdatedAdmin() ?? 0;

        $newAdmin = $currentNewAdmin;
        $updatedAdmin = $currentUpdatedAdmin;

        if ($customerTransfer->getIsNew() === true) {
            $newAdmin++;
        }

        if ($customerTransfer->getIsNew() !== true && $customerTransfer->getIsUpdated() === true) {
            $updatedAdmin++;
        }

        $importStatisticTransfer->setNewAdmin($newAdmin);
        $importStatisticTransfer->setUpdatedAdmin($updatedAdmin);

        return $importStatisticTransfer;
    }

    /**
     * @param string $message
     * @param array<string, mixed> $data
     *
     * @return $this
     */
    protected function addErrorMessage($message, array $data = [])
    {
        $this->getMessenger()->addErrorMessage($this->createMessageTransfer($message, $data));

        return $this;
    }

    /**
     * @param string $message
     * @param array<string, mixed> $data
     *
     * @return \Generated\Shared\Transfer\MessageTransfer
     */
    private function createMessageTransfer(string $message, array $data = []): MessageTransfer
    {
        $messageTransfer = new MessageTransfer();
        $messageTransfer->setValue($message);
        $messageTransfer->setParameters($data);

        return $messageTransfer;
    }
}
