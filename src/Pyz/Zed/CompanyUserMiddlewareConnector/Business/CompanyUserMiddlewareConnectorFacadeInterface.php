<?php

namespace Pyz\Zed\CompanyUserMiddlewareConnector\Business;

use Generated\Shared\Transfer\ValidatorConfigTransfer;
use Generated\Shared\Transfer\MapperConfigTransfer;
use Generated\Shared\Transfer\TranslatorConfigTransfer;
use Pyz\Zed\Process\Business\Importer\ImporterInterface;

/**
 * @method \Pyz\Zed\CompanyUserMiddlewareConnector\Business\CompanyUserMiddlewareConnectorBusinessFactory getFactory()
 */
interface CompanyUserMiddlewareConnectorFacadeInterface
{
    /**
     * @return \Generated\Shared\Transfer\ValidatorConfigTransfer
     */
    public function getCompanyUserValidatorConfig(): ValidatorConfigTransfer;

    /**
     * @return \Generated\Shared\Transfer\MapperConfigTransfer
     */
    public function getCompanyUserMapperConfig(): MapperConfigTransfer;

    /**
     * @return \Generated\Shared\Transfer\TranslatorConfigTransfer
     */
    public function getCompanyUserTranslatorConfig(): TranslatorConfigTransfer;

    /**
     * @return \Pyz\Zed\Process\Business\Importer\ImporterInterface
     */
    public function getCompanyUserImporter(): ImporterInterface;
}
