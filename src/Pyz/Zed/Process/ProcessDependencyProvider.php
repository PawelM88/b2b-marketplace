<?php

namespace Pyz\Zed\Process;

use Pyz\Zed\CompanyUserMiddlewareConnector\Communication\Plugin\Configuration\CompanyUserMiddlewareConnectorConfigurationProfilePlugin;
use SprykerMiddleware\Zed\Process\ProcessDependencyProvider as SprykerProcessDependencyProvider;

class ProcessDependencyProvider extends SprykerProcessDependencyProvider
{
    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ConfigurationProfilePluginInterface[]
     */
    protected function getConfigurationProfilePluginsStack(): array
    {
        $profileStack = parent::getConfigurationProfilePluginsStack();
        $profileStack[] = new CompanyUserMiddlewareConnectorConfigurationProfilePlugin();

        return $profileStack;
    }
}