<?php

declare(strict_types=1);

namespace Pyz\Zed\Process;

use Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\Plugin\Configuration\ProductAbstractMiddlewareConnectorConfigurationProfilePlugin;
use SprykerMiddleware\Zed\Process\ProcessDependencyProvider as SprykerProcessDependencyProvider;

class ProcessDependencyProvider extends SprykerProcessDependencyProvider
{
    /**
     * @return array<\SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ConfigurationProfilePluginInterface>
     */
    protected function getConfigurationProfilePluginsStack(): array
    {
        $profileStack = parent::getConfigurationProfilePluginsStack();
        $profileStack[] = new ProductAbstractMiddlewareConnectorConfigurationProfilePlugin();

        return $profileStack;
    }
}
