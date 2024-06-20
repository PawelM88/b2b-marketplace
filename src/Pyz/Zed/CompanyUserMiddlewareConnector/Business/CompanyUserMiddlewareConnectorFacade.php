<?php

namespace Pyz\Zed\CompanyUserMiddlewareConnector\Business;

use Generated\Shared\Transfer\MapperConfigTransfer;
use Generated\Shared\Transfer\TranslatorConfigTransfer;
use Generated\Shared\Transfer\ValidatorConfigTransfer;
use Pyz\Zed\Process\Business\Importer\ImporterInterface;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pyz\Zed\CompanyUserMiddlewareConnector\Business\CompanyUserMiddlewareConnectorBusinessFactory getFactory()
 */
class CompanyUserMiddlewareConnectorFacade extends AbstractFacade implements
    CompanyUserMiddlewareConnectorFacadeInterface
{
    /**
     * @return \Generated\Shared\Transfer\ValidatorConfigTransfer
     */
    public function getCompanyUserValidatorConfig(): ValidatorConfigTransfer
    {
        return $this->getFactory()
            ->createCompanyUserValidationRuleSet()
            ->getValidatorConfig();
    }

    /**
     * @return \Generated\Shared\Transfer\MapperConfigTransfer
     */
    public function getCompanyUserMapperConfig(): MapperConfigTransfer
    {
        return $this->getFactory()
            ->createCompanyUserMap()
            ->getMapperConfig();
    }

    /**
     * @return \Generated\Shared\Transfer\TranslatorConfigTransfer
     */
    public function getCompanyUserTranslatorConfig(): TranslatorConfigTransfer
    {
        return $this->getFactory()
            ->createCompanyUserDictionary()
            ->getTranslatorConfig();
    }

    /**
     * @return \Pyz\Zed\Process\Business\Importer\ImporterInterface
     */
    public function getCompanyUserImporter(): ImporterInterface
    {
        return $this->getFactory()->createCompanyUserImporter();
    }
}
