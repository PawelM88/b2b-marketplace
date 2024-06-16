<?php

declare(strict_types=1);

namespace Pyz\Zed\ProductAbstractMiddlewareConnector\Business;

use Generated\Shared\Transfer\MapperConfigTransfer;
use Generated\Shared\Transfer\TranslatorConfigTransfer;
use Generated\Shared\Transfer\ValidatorConfigTransfer;
use Pyz\Zed\Process\Business\Importer\ImporterInterface;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pyz\Zed\ProductAbstractMiddlewareConnector\Business\ProductAbstractMiddlewareConnectorBusinessFactory getFactory()
 */
class ProductAbstractMiddlewareConnectorFacade extends AbstractFacade implements ProductAbstractMiddlewareConnectorFacadeInterface
{
    /**
     * @return \Generated\Shared\Transfer\ValidatorConfigTransfer
     */
    public function getProductAbstractValidatorConfig(): ValidatorConfigTransfer
    {
        return $this->getFactory()
            ->createProductAbstractValidationRuleSet()
            ->getValidatorConfig();
    }

    /**
     * @return \Generated\Shared\Transfer\MapperConfigTransfer
     */
    public function getProductAbstractMapperConfig(): MapperConfigTransfer
    {
        return $this->getFactory()
            ->createProductAbstractMap()
            ->getMapperConfig();
    }

    /**
     * @return \Generated\Shared\Transfer\TranslatorConfigTransfer
     */
    public function getProductAbstractTranslatorConfig(): TranslatorConfigTransfer
    {
        return $this->getFactory()
            ->createProductAbstractDictionary()
            ->getTranslatorConfig();
    }

    /**
     * @return \Pyz\Zed\Process\Business\Importer\ImporterInterface
     */
    public function getProductAbstractImporter(): ImporterInterface
    {
        return $this->getFactory()->createProductAbstractImporter();
    }
}
