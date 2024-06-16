<?php

namespace Pyz\Zed\ProductAbstractMiddlewareConnector\Business;

use Generated\Shared\Transfer\MapperConfigTransfer;
use Generated\Shared\Transfer\TranslatorConfigTransfer;
use Generated\Shared\Transfer\ValidatorConfigTransfer;
use Pyz\Zed\Process\Business\Importer\ImporterInterface;

/**
 * @method \Pyz\Zed\ProductAbstractMiddlewareConnector\Business\ProductAbstractMiddlewareConnectorBusinessFactory getFactory()
 */
interface ProductAbstractMiddlewareConnectorFacadeInterface
{
    /**
     * @return \Generated\Shared\Transfer\ValidatorConfigTransfer
     */
    public function getProductAbstractValidatorConfig(): ValidatorConfigTransfer;

    /**
     * @return \Generated\Shared\Transfer\MapperConfigTransfer
     */
    public function getProductAbstractMapperConfig(): MapperConfigTransfer;

    /**
     * @return \Generated\Shared\Transfer\TranslatorConfigTransfer
     */
    public function getProductAbstractTranslatorConfig(): TranslatorConfigTransfer;

    /**
     * @return \Pyz\Zed\Process\Business\Importer\ImporterInterface
     */
    public function getProductAbstractImporter(): ImporterInterface;
}
