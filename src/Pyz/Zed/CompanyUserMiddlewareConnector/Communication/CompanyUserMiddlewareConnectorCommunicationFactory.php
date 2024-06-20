<?php

namespace Pyz\Zed\CompanyUserMiddlewareConnector\Communication;

use Pyz\Zed\CompanyUserMiddlewareConnector\CompanyUserMiddlewareConnectorDependencyProvider;
use SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface;
use SprykerMiddleware\Zed\Process\Communication\ProcessCommunicationFactory;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Iterator\ProcessIteratorPluginInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Log\MiddlewareLoggerConfigPluginInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\InputStreamPluginInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\OutputStreamPluginInterface;
use Pyz\Zed\Process\Business\Stream\StreamFactory;
use Pyz\Zed\Process\Business\Stream\StreamFactoryInterface;

class CompanyUserMiddlewareConnectorCommunicationFactory extends ProcessCommunicationFactory
{
    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\InputStreamPluginInterface
     */
    public function getCompanyUserInputStreamPlugin(): InputStreamPluginInterface
    {
        return $this->getProvidedDependency(
            CompanyUserMiddlewareConnectorDependencyProvider::COMPANY_USER_INPUT_STREAM_PLUGIN
        );
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\OutputStreamPluginInterface
     */
    public function getCompanyUserOutputStreamPlugin(): OutputStreamPluginInterface
    {
        return $this->getProvidedDependency(
            CompanyUserMiddlewareConnectorDependencyProvider::COMPANY_USER_OUTPUT_STREAM_PLUGIN
        );
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Iterator\ProcessIteratorPluginInterface
     */
    public function getCompanyUserIteratorPlugin(): ProcessIteratorPluginInterface
    {
        return $this->getProvidedDependency(
            CompanyUserMiddlewareConnectorDependencyProvider::COMPANY_USER_ITERATOR_PLUGIN
        );
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Log\MiddlewareLoggerConfigPluginInterface
     */
    public function getCompanyUserLoggerConfigPlugin(): MiddlewareLoggerConfigPluginInterface
    {
        return $this->getProvidedDependency(
            CompanyUserMiddlewareConnectorDependencyProvider::COMPANY_USER_LOGGER_PLUGIN
        );
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface[]
     */
    public function getCompanyUserStagePluginStack(): array
    {
        return $this->getProvidedDependency(
            CompanyUserMiddlewareConnectorDependencyProvider::COMPANY_USER_STAGE_PLUGIN_STACK
        );
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface[]
     */
    public function getCompanyUserProcesses(): array
    {
        return $this->getProvidedDependency(CompanyUserMiddlewareConnectorDependencyProvider::COMPANY_USER_PROCESSES);
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface
     */
    public function getProcessFacade(): ProcessFacadeInterface
    {
        return $this->getProvidedDependency(CompanyUserMiddlewareConnectorDependencyProvider::FACADE_PROCESS);
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Validator\ValidatorPluginInterface[]
     */
    public function getCompanyUserValidatorPlugins(): array
    {
        return $this->getProvidedDependency(
            CompanyUserMiddlewareConnectorDependencyProvider::COMPANY_USER_VALIDATOR_PLUGINS
        );
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\TranslatorFunctionInterface[]
     */
    public function getCompanyUserTranslatorFunctions(): array
    {
        return $this->getProvidedDependency(
            CompanyUserMiddlewareConnectorDependencyProvider::COMPANY_USER_TRANSLATOR_FUNCTIONS
        );
    }

    /**
     * @return \Pyz\Zed\Process\Business\Stream\StreamFactoryInterface
     */
    public function createStreamFactory(): StreamFactoryInterface
    {
        return new StreamFactory();
    }
}
