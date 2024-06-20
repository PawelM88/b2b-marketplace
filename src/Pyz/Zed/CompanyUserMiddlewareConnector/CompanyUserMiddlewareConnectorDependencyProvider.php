<?php

namespace Pyz\Zed\CompanyUserMiddlewareConnector;

use Pyz\Zed\CompanyUserMiddlewareConnector\Communication\Plugin\CompanyUserMapperStagePlugin;
use Pyz\Zed\CompanyUserMiddlewareConnector\Communication\Plugin\CompanyUserTranslationStagePlugin;
use Pyz\Zed\CompanyUserMiddlewareConnector\Communication\Plugin\CompanyUserValidatorStagePlugin;
use Pyz\Zed\CompanyUserMiddlewareConnector\Communication\Plugin\Configuration\CompanyUserTransformationProcessPlugin;
use Pyz\Zed\CompanyUserMiddlewareConnector\Communication\Plugin\Stream\CompanyUserDataImportOutputStreamPlugin;
use Pyz\Zed\CompanyUserMiddlewareConnector\Communication\Plugin\TranslatorFunction\CompanyKeyReformatTranslatorFunctionPlugin;
use Pyz\Zed\CompanyUserMiddlewareConnector\Communication\Plugin\TranslatorFunction\CountryNamePlToDeTranslatorFunctionPlugin;
use Pyz\Zed\CompanyUserMiddlewareConnector\Communication\Plugin\TranslatorFunction\UserRemoveTranslatorFunctionPlugin;
use Pyz\Zed\Process\Communication\Plugin\Validator\NotContainValidatorPlugin;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Iterator\NullIteratorPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Log\MiddlewareLoggerConfigPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Stream\XmlInputStreamPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\StreamReaderStagePlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\StreamWriterStagePlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Validator\LengthValidatorPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Validator\NotBlankValidatorPlugin;

class CompanyUserMiddlewareConnectorDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const COMPANY_USER_INPUT_STREAM_PLUGIN = 'COMPANY_USER_INPUT_STREAM_PLUGIN';

    /**
     * @var string
     */
    public const COMPANY_USER_OUTPUT_STREAM_PLUGIN = 'COMPANY_USER_OUTPUT_STREAM_PLUGIN';

    /**
     * @var string
     */
    public const COMPANY_USER_ITERATOR_PLUGIN = 'COMPANY_USER_ITERATOR_PLUGIN';

    /**
     * @var string
     */
    public const COMPANY_USER_STAGE_PLUGIN_STACK = 'COMPANY_USER_STAGE_PLUGIN_STACK';

    /**
     * @var string
     */
    public const COMPANY_USER_LOGGER_PLUGIN = 'COMPANY_USER_LOGGER_PLUGIN';

    /**
     * @var string
     */
    public const COMPANY_USER_PROCESSES = 'COMPANY_USER_PROCESSES';

    /**
     * @var string
     */
    public const COMPANY_USER_VALIDATOR_PLUGINS = 'COMPANY_USER_VALIDATOR_PLUGINS';

    /**
     * @var string
     */
    public const COMPANY_USER_TRANSLATOR_FUNCTIONS = 'COMPANY_USER_TRANSLATOR_FUNCTIONS';

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
        $container = $this->addCompanyUserProcesses($container);
        $container = $this->addCompanyUserTransformationProcessPlugins($container);
        $container = $this->addCompanyUserValidatorsPlugins($container);
        $container = $this->addCompanyUserTranslatorFunctionsPlugins($container);

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
    protected function addCompanyUserTransformationProcessPlugins(Container $container): Container
    {
        $container[static::COMPANY_USER_INPUT_STREAM_PLUGIN] = function () {
            return new XmlInputStreamPlugin();
        };
        $container[static::COMPANY_USER_OUTPUT_STREAM_PLUGIN] = function () {
            return new CompanyUserDataImportOutputStreamPlugin();
        };
        $container[static::COMPANY_USER_ITERATOR_PLUGIN] = function () {
            return new NullIteratorPlugin();
        };
        $container[static::COMPANY_USER_STAGE_PLUGIN_STACK] = function () {
            return [
                new StreamReaderStagePlugin(),
                new CompanyUserValidatorStagePlugin(),
                new CompanyUserMapperStagePlugin(),
                new CompanyUserTranslationStagePlugin(),
                new StreamWriterStagePlugin(),
            ];
        };
        $container[static::COMPANY_USER_LOGGER_PLUGIN] = function () {
            return new MiddlewareLoggerConfigPlugin();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyUserProcesses(Container $container): Container
    {
        $container[static::COMPANY_USER_PROCESSES] = function () {
            return $this->getCompanyUserProcesses();
        };
        return $container;
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface[]
     */
    protected function getCompanyUserProcesses(): array
    {
        return [
            new CompanyUserTransformationProcessPlugin(),
        ];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyUserValidatorsPlugins(Container $container): Container
    {
        $container[static::COMPANY_USER_VALIDATOR_PLUGINS] = function () {
            return $this->getCompanyUserValidatorsPlugins();
        };
        return $container;
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Validator\GenericValidatorPluginInterface[]
     */
    public function getCompanyUserValidatorsPlugins(): array
    {
        return [
            new NotBlankValidatorPlugin(),
            new NotContainValidatorPlugin(),
            new LengthValidatorPlugin()
        ];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addCompanyUserTranslatorFunctionsPlugins(Container $container): Container
    {
        $container[static::COMPANY_USER_TRANSLATOR_FUNCTIONS] = function () {
            return $this->getCompanyUserTranslatorFunctionPlugins();
        };
        return $container;
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\TranslatorFunction\GenericTranslatorFunctionPluginInterface[]
     */
    public function getCompanyUserTranslatorFunctionPlugins(): array
    {
        return [
            new UserRemoveTranslatorFunctionPlugin(),
            new CountryNamePlToDeTranslatorFunctionPlugin(),
            new CompanyKeyReformatTranslatorFunctionPlugin()
        ];
    }
}
