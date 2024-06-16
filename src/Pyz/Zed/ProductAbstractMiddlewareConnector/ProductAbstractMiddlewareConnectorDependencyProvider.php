<?php

declare(strict_types=1);

namespace Pyz\Zed\ProductAbstractMiddlewareConnector;

use Pyz\Zed\Process\Communication\Plugin\TranslatorFunction\ColorsNameToColorsCodeTranslatorFunctionPlugin;
use Pyz\Zed\Process\Communication\Plugin\TranslatorFunction\SpacesToDashesTranslatorFunctionPlugin;
use Pyz\Zed\Process\Communication\Plugin\Validator\NotContainValidatorPlugin;
use Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\Plugin\Configuration\ProductAbstractTransformationProcessPlugin;
use Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\Plugin\ProductAbstractMapperStagePlugin;
use Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\Plugin\ProductAbstractTranslationStagePlugin;
use Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\Plugin\ProductAbstractValidatorStagePlugin;
use Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\Plugin\Stream\ProductAbstractDataImportOutputStreamPlugin;
use Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\Plugin\TranslatorFunction\PrzewodyToCablesTranslatorFunctionPlugin;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Iterator\NullIteratorPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Log\MiddlewareLoggerConfigPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Stream\JsonRowInputStreamPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\StreamReaderStagePlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\StreamWriterStagePlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Validator\LengthValidatorPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Validator\NotBlankValidatorPlugin;

class ProductAbstractMiddlewareConnectorDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const PRODUCT_ABSTRACT_INPUT_STREAM_PLUGIN = 'PRODUCT_ABSTRACT_INPUT_STREAM_PLUGIN';

    /**
     * @var string
     */
    public const PRODUCT_ABSTRACT_OUTPUT_STREAM_PLUGIN = 'PRODUCT_ABSTRACT_OUTPUT_STREAM_PLUGIN';

    /**
     * @var string
     */
    public const PRODUCT_ABSTRACT_ITERATOR_PLUGIN = 'PRODUCT_ABSTRACT_ITERATOR_PLUGIN';

    /**
     * @var string
     */
    public const PRODUCT_ABSTRACT_STAGE_PLUGIN_STACK = 'PRODUCT_ABSTRACT_STAGE_PLUGIN_STACK';

    /**
     * @var string
     */
    public const PRODUCT_ABSTRACT_LOGGER_PLUGIN = 'PRODUCT_ABSTRACT_LOGGER_PLUGIN';

    /**
     * @var string
     */
    public const PRODUCT_ABSTRACT_PROCESSES = 'PRODUCT_ABSTRACT_PROCESSES';

    /**
     * @var string
     */
    public const PRODUCT_ABSTRACT_VALIDATOR_PLUGINS = 'PRODUCT_ABSTRACT_VALIDATOR_PLUGINS';

    /**
     * @var string
     */
    public const PRODUCT_ABSTRACT_TRANSLATOR_FUNCTIONS = 'PRODUCT_ABSTRACT_TRANSLATOR_FUNCTIONS';

    /**
     * @var string
     */
    public const FACADE_PROCESS = 'FACADE_PROCESS';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = $this->addFacadeProcess($container);
        $container = $this->addProductAbstractProcesses($container);
        $container = $this->addProductAbstractTransformationProcessPlugins($container);
        $container = $this->addProductAbstractValidatorsPlugins($container);
        $container = $this->addProductAbstractTranslatorFunctionsPlugins($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addFacadeProcess(Container $container): Container
    {
        $container[static::FACADE_PROCESS] = function (Container $container) {
            return $container->getLocator()->process()->facade();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProductAbstractTransformationProcessPlugins(Container $container): Container
    {
        $container[static::PRODUCT_ABSTRACT_INPUT_STREAM_PLUGIN] = function () {
            return new JsonRowInputStreamPlugin();
        };
        $container[static::PRODUCT_ABSTRACT_OUTPUT_STREAM_PLUGIN] = function () {
            return new ProductAbstractDataImportOutputStreamPlugin();
        };
        $container[static::PRODUCT_ABSTRACT_ITERATOR_PLUGIN] = function () {
            return new NullIteratorPlugin();
        };
        $container[static::PRODUCT_ABSTRACT_STAGE_PLUGIN_STACK] = function () {
            return [
                new StreamReaderStagePlugin(),
                new ProductAbstractValidatorStagePlugin(),
                new ProductAbstractMapperStagePlugin(),
                new ProductAbstractTranslationStagePlugin(),
                new StreamWriterStagePlugin(),
            ];
        };
        $container[static::PRODUCT_ABSTRACT_LOGGER_PLUGIN] = function () {
            return new MiddlewareLoggerConfigPlugin();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProductAbstractProcesses(Container $container): Container
    {
        $container[static::PRODUCT_ABSTRACT_PROCESSES] = function () {
            return $this->getProductAbstractProcesses();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProductAbstractValidatorsPlugins(Container $container): Container
    {
        $container[static::PRODUCT_ABSTRACT_VALIDATOR_PLUGINS] = function () {
            return $this->getProductAbstractValidatorsPlugins();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProductAbstractTranslatorFunctionsPlugins(Container $container): Container
    {
        $container[static::PRODUCT_ABSTRACT_TRANSLATOR_FUNCTIONS] = function () {
            return $this->getProductAbstractTranslatorFunctionPlugins();
        };

        return $container;
    }

    /**
     * @return array<\SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface>
     */
    protected function getProductAbstractProcesses(): array
    {
        return [
            new ProductAbstractTransformationProcessPlugin(),
        ];
    }

    /**
     * @return array<\SprykerMiddleware\Zed\Process\Dependency\Plugin\Validator\GenericValidatorPluginInterface>
     */
    public function getProductAbstractValidatorsPlugins(): array
    {
        return [
            new NotBlankValidatorPlugin(),
            new LengthValidatorPlugin(),
            new NotContainValidatorPlugin(),
        ];
    }

    /**
     * @return array<\SprykerMiddleware\Zed\Process\Dependency\Plugin\TranslatorFunction\GenericTranslatorFunctionPluginInterface>
     */
    public function getProductAbstractTranslatorFunctionPlugins(): array
    {
        return [
            new PrzewodyToCablesTranslatorFunctionPlugin(),
            new SpacesToDashesTranslatorFunctionPlugin(),
            new ColorsNameToColorsCodeTranslatorFunctionPlugin(),
        ];
    }
}
