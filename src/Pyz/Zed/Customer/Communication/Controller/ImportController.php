<?php

declare(strict_types=1);

namespace Pyz\Zed\Customer\Communication\Controller;

use Generated\Shared\Transfer\CompanyTransfer;
use Generated\Shared\Transfer\CustomerCsvValidationResultTransfer;
use Generated\Shared\Transfer\CustomerImportTransfer;
use Generated\Shared\Transfer\CustomerListImportRequestTransfer;
use Generated\Shared\Transfer\CustomerListImportResponseTransfer;
use Generated\Shared\Transfer\CustomerTransfer;
use Generated\Shared\Transfer\MessageTransfer;
use Pyz\Zed\Customer\Communication\Form\CustomerImportForm;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Zed\Customer\Communication\CustomerCommunicationFactory getFactory()
 * @method \Pyz\Zed\Customer\Persistence\CustomerRepositoryInterface getRepository()
 * @method \Pyz\Zed\Customer\Business\CustomerFacadeInterface getFacade()
 */
class ImportController extends AbstractController
{
    /**
     * @var string
     */
    public const URL_IMPORT_PAGE = '/customer/import';

    /**
     * @return array<string, mixed>
     */
    public function indexAction(): array
    {
        $customerImportForm = $this->getFactory()->getCustomerImportForm();

        return $this->viewResponse([
            'importForm' => $customerImportForm->createView(),
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
        $customerImportForm = $this->getFactory()->getCustomerImportForm();
        $customerImportForm->handleRequest($request);

        $customerCsvValidationResultTransfer = $this->validateCustomerImportForm($customerImportForm);

        if ($customerCsvValidationResultTransfer->getIsSuccess() === false) {
            $this->addErrorMessage($customerCsvValidationResultTransfer->getError());

            return $this->redirectResponse(static::URL_IMPORT_PAGE);
        }

        return $this->prepareIndexData($customerImportForm);
    }

    /**
     * @param \Symfony\Component\Form\FormInterface $customerImportForm
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Generated\Shared\Transfer\CustomerCsvValidationResultTransfer
     */
    protected function validateCustomerImportForm(FormInterface $customerImportForm): CustomerCsvValidationResultTransfer
    {
        $uploadedFileData = $customerImportForm
            ->get(CustomerImportForm::FIELD_FILE_UPLOAD)
            ->getData();

        return $this->getFactory()
            ->getCustomerCsvImporterFacade()
            ->validateCsvFile($uploadedFileData);
    }

    /**
     * @param \Symfony\Component\Form\FormInterface $customerImportForm
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return array<string, mixed>
     */
    protected function prepareIndexData(FormInterface $customerImportForm): array
    {
        $customerListImportResponseTransfer = $this->handleCustomerImportForm($customerImportForm);
        $customerListImportRequestTransfer = $customerListImportResponseTransfer->getCustomerListImportRequest();

        $errorTable = $this->getFactory()->createImportErrorTable($customerListImportResponseTransfer);
        $errorTableData = $this->getFactory()
            ->createTableFormatter()
            ->formatAbstractTableToArray($errorTable);

        if (empty($errorTableData['data'])) {
            $this->saveCustomerCsvData($customerListImportRequestTransfer);
        }

        return $this->viewResponse([
            'importForm' => $customerImportForm->createView(),
            'errorTable' => $errorTableData,
        ]);
    }

    /**
     * @param \Symfony\Component\Form\FormInterface $importForm
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Generated\Shared\Transfer\CustomerListImportResponseTransfer
     */
    protected function handleCustomerImportForm(
        FormInterface $importForm,
    ): CustomerListImportResponseTransfer {
        $uploadedFile = $importForm
            ->get(CustomerImportForm::FIELD_FILE_UPLOAD)
            ->getData();

        $customerListImportRequestTransfer = new CustomerListImportRequestTransfer();

        $customerListImportRequestTransfer = $this->getFactory()
            ->getCustomerCsvImporterFacade()
            ->readCustomerImportTransfersFromCsvFile($uploadedFile, $customerListImportRequestTransfer);

        return $this->getFactory()
            ->getCustomerCsvImporterFacade()
            ->validateCustomerCsvData($customerListImportRequestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerListImportRequestTransfer $customerListImportRequestTransfer
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return void
     */
    private function saveCustomerCsvData(CustomerListImportRequestTransfer $customerListImportRequestTransfer): void
    {
        foreach ($customerListImportRequestTransfer->getItems() as $customerImportTransfer) {
            $companyTransfer = $this->processCompanyData($customerImportTransfer);
            $customerTransfer = $this->processCustomerData($customerImportTransfer);

            $mappedCompanyUser = $this->getFactory()->getCustomerCsvImporterFacade(
            )->mapCustomerAndCompanyDataToCompanyUser(
                $customerTransfer,
                $companyTransfer,
                $customerImportTransfer->getCompanyBusinessUnit(),
            );

            $this->getFactory()->getCompanyUserFacade()->create($mappedCompanyUser);
        }
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerImportTransfer $customerImportTransfer
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Generated\Shared\Transfer\CompanyTransfer
     */
    private function processCompanyData(CustomerImportTransfer $customerImportTransfer): CompanyTransfer
    {
        $companyFacade = $this->getFactory()->getCompanyFacade();
        $customerCsvImporterFacade = $this->getFactory()->getCustomerCsvImporterFacade();
        $companyBusinessUnitFacade = $this->getFactory()->getCompanyBusinessUnitFacade();
        $companyUnitAddressFacade = $this->getFactory()->getCompanyUnitAddressFacade();

        $companyTransfer = $companyFacade->createCompanyBasedOnDataFromCombinedCsvFile(
            $customerImportTransfer->getCompany(),
        );

        $mappedCompanyBusinessUnitTransfer = $customerCsvImporterFacade->mapCompanyToCompanyBusinessUnit(
            $companyTransfer,
            $customerImportTransfer->getCompanyBusinessUnit(),
        );
        $companyBusinessUnitTransfer = $companyBusinessUnitFacade->createCompanyBusinessUnitBasedOnDataFromCombinedCsvFile(
            $mappedCompanyBusinessUnitTransfer,
        );

        $mappedCompanyUnitAddress = $customerCsvImporterFacade->mapCompanyToCompanyUnitAddress(
            $companyTransfer,
            $customerImportTransfer->getCompanyUnitAddress(),
        );
        $companyUnitAddressTransfer = $companyUnitAddressFacade->createCompanyUnitAddressBasedOnDataFromCombinedCsvFile($mappedCompanyUnitAddress);

        $spyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer = $customerCsvImporterFacade->mapCompanyBusinessUnitAndCompanyUnitAddressToCompanyBusinessUnitAddress(
            $companyBusinessUnitTransfer,
            $companyUnitAddressTransfer,
        );
        $companyUnitAddressFacade->saveAddressToBusinessUnitRelationFromCombinedCsvFile(
            $spyCompanyUnitAddressToCompanyBusinessUnitEntityTransfer,
        );

        return $companyTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\CustomerImportTransfer $customerImportTransfer
     *
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Generated\Shared\Transfer\CustomerTransfer
     */
    private function processCustomerData(
        CustomerImportTransfer $customerImportTransfer,
    ): CustomerTransfer {
        $customerFacade = $this->getFactory()->getCustomerFacade();

        $customerResponseTransfer = $customerFacade->addCustomer($customerImportTransfer->getCustomer());
        if ($customerResponseTransfer->getCustomerTransfer() === null) {
            $customerResponseTransfer = $customerFacade->getCustomerByEmail($customerImportTransfer->getCustomer());
        }

        return $customerResponseTransfer->getCustomerTransfer();
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
