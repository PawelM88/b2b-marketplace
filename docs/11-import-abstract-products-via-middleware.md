# Middleware
Suppose we receive a file with input data for product-abstract from an external system.

### data/import/middleware/product_abstract.json
```json lines
{"type":"przewody","sku":"cable test 1","kolor":"red","name":[{"locale":"en","name":"Test Cable 1"},{"locale":"de","name":"Tst Kabel 1"}],"desc":"Sample description of test cable 1.","brand":"HP"}
{"type":"przewody","sku":"cable#test#2","kolor":"red","name":[{"locale":"en","name":"Test Cable 2"},{"locale":"de","name":"Tst Kabel 2"}],"desc":"Sample description of test cable 2.","brand":"HP"}
{"type":"przewody","sku":"cable test 3","kolor":"green","name":[{"locale":"en","name":"Test Cable 3"},{"locale":"de","name":"Tst Kabel 3"}],"desc":"Very long item description that has over 100 chars. For some made-up reasons, such long descriptions are forbidden ;)","brand":"HP"}
{"type":"przewody","sku":"cable test 4","kolor":"green","name":[{"locale":"en","name":"Test Cable 4"},{"locale":"de","name":"Tst Kabel 4"}],"desc":"","brand":"HP"}
{"type":"przewody","sku":"cable test 5","kolor":"blue","name":[{"locale":"en","name":"Test Cable 5"},{"locale":"de","name":"Tst Kabel 5"}],"desc":"Sample description of test cable 5.","brand":"HP"}
{"type":"","sku":"cable test 6","kolor":"blue","name":[{"locale":"en","name":"Test Cable 6"},{"locale":"de","name":"Tst Kabel 6"}],"desc":"Sample description of test cable 6.","brand":"HP"}
{"type":"przewody","sku":"cable test 7","kolor":"white","name":[{"locale":"en","name":"Test Cable 7"},{"locale":"de","name":"Tst Kabel 7"}],"desc":"Sample description of test cable 7.","brand":"VGA"}
```
Our middleware process should:
1. Read the input file
2. Validate the data for each row and pass only those entries that meet the appropriate criteria
3. Map the fields in the file to the correct ones (required in the Spryker)
4. Convert the data to a format compatible with the format used in the Spryker
5. Import the data

The input data, for the purpose of demonstrating various middleware options, intentionally contains some errors.
We will also use rules to show as many middleware capabilities as possible.

### Data validation
1. Field `type` cannot be empty
2. Field `desc` cannot be empty
3. Field `desc` can have a max 100 characters
4. Field `sku` cannot contain `#`
5. Field `sku` cannot contain the phrase `test 5`

### Field mapping
Target field | Source file field
--- | ---
abstract_sku | sku
color_code | kolor
category_key | type
name.en_US | name (for the appropriate language)
name.de_DE | name (for the appropriate language)
description.en_US | desc
description.de_DE | desc
url.en_US | string("/en/") + sku
url.de_DE | string("/de/") + sku
attribute_key_1 | string("brand")
value_1 | brand

### Field value modifications
1. In the `sku` field, replace all spaces with dashes
2. In the `type` field, replace the string `przewody` with `cables`
3. In the `kolor` field, change the name of the color to its hex code (e.g. white to #FFFFFF)


# Middleware setup
To be able to use the middleware functionality, you must first install the appropriate package using composer:
```shell
composer require "spryker-middleware/process":"^1.3"
```

### config/Shared/config_default.php
We add the appropriate namespace to the configuration file:
```php
{...}
$config[KernelConstants::CORE_NAMESPACES] = [
    {...}
    'SprykerMiddleware',
    {...}
];
{...}
```

### src/Pyz/Zed/Console/ConsoleDependencyProvider.php
We add middleware commands to console commands
```php
{...}
use SprykerMiddleware\Zed\Process\Communication\Console\ProcessConsole;
{...}
    protected function getConsoleCommands(Container $container): array
    {
        $commands = [
            {...}
            new ProcessConsole(),
        ];
{...}
```

# Basic functionality
At the beginning, we will create a new middleware module and its basic configuration, and we will make it read the data from the file and, without changing it, save it to the new result file.

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/ProductAbstractMiddlewareConnectorDependencyProvider.php
```php
<?php

namespace Pyz\Zed\ProductAbstractMiddlewareConnector;

use Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\Plugin\Configuration\ProductAbstractTransformationProcessPlugin;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Iterator\NullIteratorPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Log\MiddlewareLoggerConfigPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Stream\JsonOutputStreamPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Stream\JsonRowInputStreamPlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\StreamReaderStagePlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\StreamWriterStagePlugin;

class ProductAbstractMiddlewareConnectorDependencyProvider extends AbstractBundleDependencyProvider
{
    public const PRODUCT_ABSTRACT_INPUT_STREAM_PLUGIN = 'PRODUCT_ABSTRACT_INPUT_STREAM_PLUGIN';
    public const PRODUCT_ABSTRACT_OUTPUT_STREAM_PLUGIN = 'PRODUCT_ABSTRACT_OUTPUT_STREAM_PLUGIN';
    public const PRODUCT_ABSTRACT_ITERATOR_PLUGIN = 'PRODUCT_ABSTRACT_ITERATOR_PLUGIN';
    public const PRODUCT_ABSTRACT_STAGE_PLUGIN_STACK = 'PRODUCT_ABSTRACT_STAGE_PLUGIN_STACK';
    public const PRODUCT_ABSTRACT_LOGGER_PLUGIN = 'PRODUCT_ABSTRACT_LOGGER_PLUGIN';
    public const PRODUCT_ABSTRACT_PROCESSES = 'PRODUCT_ABSTRACT_PROCESSES';

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
            // Plugin that makes Json file read possible.
            return new JsonRowInputStreamPlugin();
        };
        $container[static::PRODUCT_ABSTRACT_OUTPUT_STREAM_PLUGIN] = function () {
            // Plugin that makes Json file format write possible.
            return new JsonOutputStreamPlugin();
        };
        $container[static::PRODUCT_ABSTRACT_ITERATOR_PLUGIN] = function () {
            return new NullIteratorPlugin();
        };
        $container[static::PRODUCT_ABSTRACT_STAGE_PLUGIN_STACK] = function () {
            /*
             * Middleware stage plugin stack.
             * The output of one is the input of the other.
             * The order of these plugins is important!
             */
            return [
                new StreamReaderStagePlugin(),
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
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface[]
     */
    protected function getProductAbstractProcesses(): array
    {
        return [
            new ProductAbstractTransformationProcessPlugin(),
        ];
    }
}
```

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Communication/ProductAbstractMiddlewareConnectorCommunicationFactory.php
```php
<?php

namespace Pyz\Zed\ProductAbstractMiddlewareConnector\Communication;

use Pyz\Zed\ProductAbstractMiddlewareConnector\ProductAbstractMiddlewareConnectorDependencyProvider;
use SprykerMiddleware\Zed\Process\Communication\ProcessCommunicationFactory;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Iterator\ProcessIteratorPluginInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Log\MiddlewareLoggerConfigPluginInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\InputStreamPluginInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\OutputStreamPluginInterface;

class ProductAbstractMiddlewareConnectorCommunicationFactory extends ProcessCommunicationFactory
{
    /**
     * @return InputStreamPluginInterface
     */
    public function getProductAbstractInputStreamPlugin(): InputStreamPluginInterface
    {
        return $this->getProvidedDependency(ProductAbstractMiddlewareConnectorDependencyProvider::PRODUCT_ABSTRACT_INPUT_STREAM_PLUGIN);
    }

    /**
     * @return OutputStreamPluginInterface
     */
    public function getProductAbstractOutputStreamPlugin(): OutputStreamPluginInterface
    {
        return $this->getProvidedDependency(ProductAbstractMiddlewareConnectorDependencyProvider::PRODUCT_ABSTRACT_OUTPUT_STREAM_PLUGIN);
    }

    /**
     * @return ProcessIteratorPluginInterface
     */
    public function getProductAbstractIteratorPlugin(): ProcessIteratorPluginInterface
    {
        return $this->getProvidedDependency(ProductAbstractMiddlewareConnectorDependencyProvider::PRODUCT_ABSTRACT_ITERATOR_PLUGIN);
    }

    /**
     * @return MiddlewareLoggerConfigPluginInterface
     */
    public function getProductAbstractLoggerConfigPlugin(): MiddlewareLoggerConfigPluginInterface
    {
        return $this->getProvidedDependency(ProductAbstractMiddlewareConnectorDependencyProvider::PRODUCT_ABSTRACT_LOGGER_PLUGIN);
    }

    /**
     * @return StagePluginInterface[]
     */
    public function getProductAbstractStagePluginStack(): array
    {
        return $this->getProvidedDependency(ProductAbstractMiddlewareConnectorDependencyProvider::PRODUCT_ABSTRACT_STAGE_PLUGIN_STACK);
    }

    /**
     * @return ProcessConfigurationPluginInterface[]
     */
    public function getProductAbstractProcesses(): array
    {
        return $this->getProvidedDependency(ProductAbstractMiddlewareConnectorDependencyProvider::PRODUCT_ABSTRACT_PROCESSES);
    }
}
```

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Communication/Plugin/Configuration/ProductAbstractTransformationProcessPlugin.php
```php
<?php

namespace Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\Plugin\Configuration;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Iterator\ProcessIteratorPluginInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Log\MiddlewareLoggerConfigPluginInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\InputStreamPluginInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\OutputStreamPluginInterface;

/**
 * @method \Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\ProductAbstractMiddlewareConnectorCommunicationFactory getFactory()
 */
class ProductAbstractTransformationProcessPlugin extends AbstractPlugin implements ProcessConfigurationPluginInterface
{
    // Middleware process name used to identify this particular middleware process.
    protected const PROCESS_NAME = 'PRODUCT_ABSTRACT_PROCESS';

    /**
     * @return string
     */
    public function getProcessName(): string
    {
        return static::PROCESS_NAME;
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\InputStreamPluginInterface
     */
    public function getInputStreamPlugin(): InputStreamPluginInterface
    {
        return $this->getFactory()
            ->getProductAbstractInputStreamPlugin();
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\OutputStreamPluginInterface
     */
    public function getOutputStreamPlugin(): OutputStreamPluginInterface
    {
        return $this->getFactory()
            ->getProductAbstractOutputStreamPlugin();
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Iterator\ProcessIteratorPluginInterface
     */
    public function getIteratorPlugin(): ProcessIteratorPluginInterface
    {
        return $this->getFactory()
            ->getProductAbstractIteratorPlugin();
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface[]
     */
    public function getStagePlugins(): array
    {
        return $this->getFactory()
            ->getProductAbstractStagePluginStack();
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Log\MiddlewareLoggerConfigPluginInterface
     */
    public function getLoggerPlugin(): MiddlewareLoggerConfigPluginInterface
    {
        return $this->getFactory()
            ->getProductAbstractLoggerConfigPlugin();
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Hook\PreProcessorHookPluginInterface[]
     */
    public function getPreProcessorHookPlugins(): array
    {
        return [];
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Hook\PostProcessorHookPluginInterface[]
     */
    public function getPostProcessorHookPlugins(): array
    {
        return [];
    }
}
```

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Communication/Plugin/Configuration/ProductAbstractMiddlewareConnectorConfigurationProfilePlugin.php
```php
<?php

namespace Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\Plugin\Configuration;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ConfigurationProfilePluginInterface;

/**
 * @method \Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\ProductAbstractMiddlewareConnectorCommunicationFactory getFactory()
 */
class ProductAbstractMiddlewareConnectorConfigurationProfilePlugin extends AbstractPlugin implements ConfigurationProfilePluginInterface
{
    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ProcessConfigurationPluginInterface[]
     */
    public function getProcessConfigurationPlugins(): array
    {
        return $this->getFactory()
            ->getProductAbstractProcesses();
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\TranslatorFunction\TranslatorFunctionPluginInterface[]
     */
    public function getTranslatorFunctionPlugins(): array
    {
        return [];
    }

    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Validator\ValidatorPluginInterface[]
     */
    public function getValidatorPlugins(): array
    {
        return [];
    }
}
```

<br />
When the basic configuration of the module is ready, we register the module in the middleware processes.

### src/Pyz/Zed/Process/ProcessDependencyProvider.php
```php
<?php

namespace Pyz\Zed\Process;

use Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\Plugin\Configuration\ProductAbstractMiddlewareConnectorConfigurationProfilePlugin;
use SprykerMiddleware\Zed\Process\ProcessDependencyProvider as SprykerProcessDependencyProvider;

class ProcessDependencyProvider extends SprykerProcessDependencyProvider
{
    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Configuration\ConfigurationProfilePluginInterface[]
     */
    protected function getConfigurationProfilePluginsStack(): array
    {
        $profileStack = parent::getConfigurationProfilePluginsStack();
        $profileStack[] = new ProductAbstractMiddlewareConnectorConfigurationProfilePlugin();

        return $profileStack;
    }
}
```

## Starting the middleware process
To start the process enter the CLI console and execute the following command:
```shell
console middleware:process:run -p "PRODUCT_ABSTRACT_PROCESS" -i data/import/middleware/product_abstract.json -o data/import/middleware/out.json
```
<ul>
<li><b>console middleware:process:run</b> - runs middleware processes</li>
<li>parametr <b>-p</b> - only starts the process with the specified name <i>("PRODUCT_ABSTRACT_PROCESS")</i></li>
<li>parametr <b>-i</b> - indicates the location of the input file</li>
<li>parametr <b>-o</b> - indicates the location of the output file</li>
</ul>

After executing the command, a file containing the same data as the source file should appear in the `data/import/middleware/out.json`.

# Validator
Once we have a basic process, we can add more elements to it.
The first stage of further data processing will be verification whether a given entry meets the criteria or should be immediately rejected.

## The field cannot be empty
In the assumptions, we had specified that both the `type` and `desc` fields cannot be empty.

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Business/Validator/ValidationRuleSet/ProductAbstractValidationRuleSet.php
This file defines the rules according to which individual fields are to be verified.
```php
<?php

namespace Pyz\Zed\ProductAbstractMiddlewareConnector\Business\Validator\ValidationRuleSet;

use SprykerMiddleware\Zed\Process\Business\Validator\ValidationRuleSet\AbstractValidationRuleSet;

class ProductAbstractValidationRuleSet extends AbstractValidationRuleSet
{
    /**
     * @return array
     */
    protected function getRules(): array
    {
        return [
            'desc' => [
                'NotBlank',
            ],
        ];
    }
}
```
The above rule says that for the `desc` field the rule called `NotBlank` from the validation plugins is to be used.<br />
So far it doesn't mean anything because the plugin hasn't been added yet. But we'll do that in a moment.<br />
First, however, the factory and the façade will be needed.

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Business/ProductAbstractMiddlewareConnectorBusinessFactory.php
```php
<?php

namespace Pyz\Zed\ProductAbstractMiddlewareConnector\Business;

use Pyz\Zed\ProductAbstractMiddlewareConnector\Business\Validator\ValidationRuleSet\ProductAbstractValidationRuleSet;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use SprykerMiddleware\Zed\Process\Business\Validator\ValidationRuleSet\ValidationRuleSetInterface;

class ProductAbstractMiddlewareConnectorBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \SprykerMiddleware\Zed\Process\Business\Validator\ValidationRuleSet\ValidationRuleSetInterface
     */
    public function createProductAbstractValidationRuleSet(): ValidationRuleSetInterface
    {
        return new ProductAbstractValidationRuleSet();
    }
}
```

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Business/ProductAbstractMiddlewareConnectorFacadeInterface.php
```php
<?php

namespace Pyz\Zed\ProductAbstractMiddlewareConnector\Business;

use Generated\Shared\Transfer\ValidatorConfigTransfer;

/**
 * @method \Pyz\Zed\ProductAbstractMiddlewareConnector\Business\ProductAbstractMiddlewareConnectorBusinessFactory getFactory()
 */
interface ProductAbstractMiddlewareConnectorFacadeInterface
{
    /**
     * @return ValidatorConfigTransfer
     */
    public function getProductAbstractValidatorConfig(): ValidatorConfigTransfer;
}

```

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Business/ProductAbstractMiddlewareConnectorFacade.php
```php
<?php

namespace Pyz\Zed\ProductAbstractMiddlewareConnector\Business;

use Generated\Shared\Transfer\ValidatorConfigTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \Pyz\Zed\ProductAbstractMiddlewareConnector\Business\ProductAbstractMiddlewareConnectorBusinessFactory getFactory()
 */
class ProductAbstractMiddlewareConnectorFacade extends AbstractFacade implements ProductAbstractMiddlewareConnectorFacadeInterface
{
    /**
     * @return ValidatorConfigTransfer
     */
    public function getProductAbstractValidatorConfig(): ValidatorConfigTransfer
    {
        return $this->getFactory()
            ->createProductAbstractValidationRuleSet()
            ->getValidatorConfig();
    }
}
```

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Communication/ProductAbstractMiddlewareConnectorCommunicationFactory.php
```php
{...}
use SprykerMiddleware\Zed\Process\Business\ProcessFacadeInterface;
{...}
    /**
     * @return ProcessFacadeInterface
     */
    public function getProcessFacade(): ProcessFacadeInterface
    {
        return $this->getProvidedDependency(ProductAbstractMiddlewareConnectorDependencyProvider::FACADE_PROCESS);
    }
{...}
```

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Communication/Plugin/ProductAbstractValidatorStagePlugin.php
```php
<?php

namespace Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\Plugin;

use Generated\Shared\Transfer\ValidatorConfigTransfer;
use Pyz\Zed\ProductAbstractMiddlewareConnector\Business\ProductAbstractMiddlewareConnectorFacadeInterface;
use Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\ProductAbstractMiddlewareConnectorCommunicationFactory;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface;

/**
 * @method ProductAbstractMiddlewareConnectorCommunicationFactory getFactory()
 * @method ProductAbstractMiddlewareConnectorFacadeInterface getFacade()
 */
class ProductAbstractValidatorStagePlugin extends AbstractPlugin implements StagePluginInterface
{
    protected const PLUGIN_NAME = 'ProductAbstractValidatorStagePlugin';

    /**
     * @return \Generated\Shared\Transfer\ValidatorConfigTransfer
     */
    protected function getValidatorConfig(): ValidatorConfigTransfer
    {
        return $this->getFacade()
            ->getProductAbstractValidatorConfig();
    }

    /**
     * @param mixed $payload
     * @param \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface $outStream
     * @param mixed $originalPayload
     *
     * @return mixed
     */
    public function process($payload, WriteStreamInterface $outStream, $originalPayload)
    {
        return $this->getFactory()
            ->getProcessFacade()
            ->validate($payload, $this->getValidatorConfig());
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return static::PLUGIN_NAME;
    }
}
```

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Communication/ProductAbstractMiddlewareConnectorCommunicationFactory.php
We configure the middleware so that it can read the list of plugins it receives:
```php
{...}
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Validator\ValidatorPluginInterface;
{...}
    /**
     * @return ValidatorPluginInterface[]
     */
    public function getProductAbstractValidatorPlugins(): array
    {
        return $this->getProvidedDependency(ProductAbstractMiddlewareConnectorDependencyProvider::PRODUCT_ABSTRACT_VALIDATOR_PLUGINS);
    }
{...}
```

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Communication/Plugin/Configuration/ProductAbstractMiddlewareConnectorConfigurationProfilePlugin.php
```php
{...}
    public function getValidatorPlugins(): array
    {
        return $this->getFactory()
            ->getProductAbstractValidatorPlugins();
    }
{...}
```

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/ProductAbstractMiddlewareConnectorDependencyProvider.php
Now we add the validator step to the queue and import the appropriate validation plugin.
```php
{...}
use Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\Plugin\ProductAbstractValidatorStagePlugin;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Validator\NotBlankValidatorPlugin;
{...}
    public const PRODUCT_ABSTRACT_VALIDATOR_PLUGINS = 'PRODUCT_ABSTRACT_VALIDATOR_PLUGINS';
{...}
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        {...}
        $container = $this->addProductAbstractValidatorsPlugins($container);

        return $container;
    }
{...}
    protected function addProductAbstractTransformationProcessPlugins(Container $container): Container
    {
        {...}
        $container[static::PRODUCT_ABSTRACT_STAGE_PLUGIN_STACK] = function () {
            return [
                new StreamReaderStagePlugin(),
                new ProductAbstractValidatorStagePlugin(),
                new StreamWriterStagePlugin(),
            ];
        };
        {...}
    }
{...}
    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProductAbstractValidatorsPlugins($container): Container
    {
        $container[static::PRODUCT_ABSTRACT_VALIDATOR_PLUGINS] = function () {
            return $this->getProductAbstractValidatorsPlugins();
        };
        return $container;
    }
{...}
    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Validator\GenericValidatorPluginInterface[]
     */
    public function getProductAbstractValidatorsPlugins(): array
    {
        return [
            new NotBlankValidatorPlugin(),
        ];
    }
{...}
```
We can add validation plugins to the `getProductAbstractValidatorsPlugins` function and thanks to that the plugin that will be added here can be used in `Business/Validator/ValidationRuleSet/ProductAbstractValidationRuleSet.php`.

The plugins we can use are in the location `vendor/spryker-middleware/process/src/SprykerMiddleware/Zed/Process/Communication/Plugin/Validator/` or we can create our own plugin, which will be shown later.

Each plugin that we will use in `ProductAbstractValidationRuleSet` is identified by its name, for example like this:
 ```php
'desc' => [
                'NotBlank', // Plugin identifier
            ],
```
This identifier is stored in each plugin in the `NAME` constant:
```php
public const NAME = 'NotBlank';
```

#### Verification
In the CLI, run the command `console middleware:process:run -p "PRODUCT_ABSTRACT_PROCESS" -i data/import/middleware/product_abstract.json -o data/import/middleware/out.json`.
When executed, you will see a message like below in the console (requires formatting):
```json
{
    "@timestamp": "2023-01-04T11:41:23.890010+00:00",
    "@version": 1,
    "host": "4585960b96df",
    "message": "Experienced tolerable process error in /data/vendor/spryker-middleware/process/src/SprykerMiddleware/Zed/Process/Business/Validator/PayloadValidator.php",
    "type": "ZED",
    "channel": "SprykerMiddleware",
    "level": "ERROR",
    "monolog_level": 400,
    "extra": {
        "file": "/data/vendor/spryker-middleware/process/src/SprykerMiddleware/Zed/Process/Business/Process/Processor.php",
        "line": 120,
        "class": "SprykerMiddleware\\Zed\\Process\\Business\\Process\\Processor",
        "callType": "->",
        "function": "process"
    },
    "context": {
        "exception": {
            "class": "SprykerMiddleware\\Zed\\Process\\Business\\Exception\\InvalidItemException",
            "message": "Item is invalid. Processing of item is skipped",
            "code": 0,
            "file": "/data/vendor/spryker-middleware/process/src/SprykerMiddleware/Zed/Process/Business/Validator/PayloadValidator.php:69",
            "trace": [
                "/data/vendor/spryker-middleware/process/src/SprykerMiddleware/Zed/Process/Business/ProcessFacade.php:183",
                "/data/src/Pyz/Zed/ProductAbstractMiddlewareConnector/Communication/Plugin/ProductAbstractValidatorStagePlugin.php:40",
                "/data/vendor/spryker-middleware/process/src/SprykerMiddleware/Zed/Process/Business/Pipeline/Processor/FingersCrossedProcessor.php:43",
                "/data/vendor/spryker-middleware/process/src/SprykerMiddleware/Zed/Process/Business/Pipeline/Pipeline.php:59",
                "/data/vendor/spryker-middleware/process/src/SprykerMiddleware/Zed/Process/Business/Process/Processor.php:116",
                "/data/vendor/spryker-middleware/process/src/SprykerMiddleware/Zed/Process/Business/ProcessFacade.php:166",
                "/data/vendor/spryker-middleware/process/src/SprykerMiddleware/Zed/Process/Communication/Console/ProcessConsole.php:180",
                "/data/vendor/symfony/console/Command/Command.php:299",
                "/data/vendor/symfony/console/Application.php:996",
                "/data/vendor/symfony/console/Application.php:295",
                "/data/vendor/spryker/console/src/Spryker/Zed/Console/Communication/Bootstrap/ConsoleBootstrap.php:111",
                "/data/vendor/symfony/console/Application.php:167",
                "/data/vendor/spryker/console/bin/console:26",
                "/data/vendor/bin/console:112"
            ]
        }
    }
}
```
The message `"message": "Item is invalid. Processing of item is skipped",` is what we expect and means that the validator detected an inconsistency and the entry was skipped.<br />
Open the file `data/import/middleware/out.json`.<br />
The output file should now not contain entry number 4, as it has been omitted.<br />
<br />

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Business/Validator/ValidationRuleSet/ProductAbstractValidationRuleSet.php
Now let's go back to the `Product Abstract Validation RuleSet` and set the rule for the `type` field.
Since we have everything set up, to reapply the plugin, simply set it for the next field as below and you're done:
```php
{...}
    protected function getRules(): array
    {
        return [
            'desc' => [
                'NotBlank',
            ],
            'type' => [
                'NotBlank',
            ],
        ];
    }
{...}
```
However, there is one more way.<br />
As a validation rule, we can use a function that takes `($value, $payload)` as a parameter and the return value is `bool`.
<ul>
<li><b>$value</b> - contains the value that is in the checked field in the current iteration.</li>
<li><b>$payload</b> - contains all fields from the given entry</li>
</ul>

If the function returns `true`, the condition is considered fulfilled and the entry is processed further.<br />
If the function returns `false`, the condition is not met and the entry is rejected.

```php
{...}
protected function getRules(): array
    {
        return [
            'desc' => [
                'NotBlank',
            ],
            'type' => function ($value, $payload) {
                return !empty($value);
            },
        ];
    }
{...}
```

Apply the above change and run the CLI command again.
```shell
console middleware:process:run -p "PRODUCT_ABSTRACT_PROCESS" -i data/import/middleware/product_abstract.json -o data/import/middleware/out.json
```
This time there will be no entries 4 and 6 in the output file.

## Maximum field length
Another limitation is the maximum number of characters that can be in the `desc` field.
In our case, it will be 100 characters.

Here we can also use one of the plugins available in the `vendor` directory.

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/ProductAbstractMiddlewareConnectorDependencyProvider.php
Let's add the appropriate plugin to the list of available plugins
```php
{...}
use SprykerMiddleware\Zed\Process\Communication\Plugin\Validator\LengthValidatorPlugin;
{...}
    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\Validator\GenericValidatorPluginInterface[]
     */
    public function getProductAbstractValidatorsPlugins(): array
    {
        return [
            new NotBlankValidatorPlugin(),
            new LengthValidatorPlugin(),
        ];
    }
{...}
```

Then we enter the plugin class and check the value of the `NAME` constant
```php
{...}
namespace SprykerMiddleware\Zed\Process\Communication\Plugin\Validator;

use SprykerMiddleware\Zed\Process\Business\Validator\Validators\LengthValidator;

class LengthValidatorPlugin extends AbstractGenericValidatorPlugin
{
    public const NAME = 'Length';
{...}
```

In addition, we also look at the `LengthValidator` class that we see in `use`
```php
{...}
namespace SprykerMiddleware\Zed\Process\Business\Validator\Validators;

class LengthValidator extends AbstractValidator
{
    public const OPTION_MIN = 'min';
    public const OPTION_MAX = 'max';
{...}
```
Thanks to this, we learn that this plugin can accept 2 parameters.<br />
With this information, we can proceed to define a new rule.

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Business/Validator/ValidationRuleSet/ProductAbstractValidationRuleSet.php
```php
{...}
    protected function getRules(): array
    {
        return [
            'desc' => [
                'NotBlank',
                [
                    'Length',
                    'options' => [
                        'max' => 100,
                    ],
                ],
            ],
            {...}
        ];
    }
{...}
```

As you can see, one field can be checked by many rules.
For this reason, they are served as an array of elements, where each element is another rule.

Rules may take no parameters, as is the case with the `NotBlank` rule.
There are also some that have optional or required parameters.

Below is an example of a plugin with parameters and a description:
```php
[
    'Length', // Plugin identifier
    'options' => [ // 'options' is required key for parameters
        // Here you provide all parameters in form 'name' => value
        'max' => 100,
    ],
],
```

Apply the above change and run the CLI command again.
```shell
console middleware:process:run -p "PRODUCT_ABSTRACT_PROCESS" -i data/import/middleware/product_abstract.json -o data/import/middleware/out.json
```
This time there will be no entries 3, 4 and 6 in the output file.

## Exclusion of selected phrases
The last requirement is for the `sku` field.
This field should not contain `#` characters and cannot contain the phrase `test 5`.

This time the `vendor` directory does not contain a plugin that could solve this problem, so we will create our own plugin for this purpose.
We will create the plugin in such a way that it can also be used by other modules, so we will create it in the `Process` module and in the `ProductAbstractMiddlewareConnector` module we will only use it.

### src/Pyz/Zed/Process/Business/Validator/Validators/NotContainValidator.php
```php
<?php

namespace Pyz\Zed\Process\Business\Validator\Validators;

use SprykerMiddleware\Zed\Process\Business\Validator\Validators\AbstractValidator;

class NotContainValidator extends AbstractValidator
{
    public const OPTION_VALUES = 'values'; // Parameter name

    /**
     * @var array
     */
    protected $requiredOptions = [self::OPTION_VALUES]; // Set parameter as required

    /**
     * @param mixed $value
     * @param array $payload
     *
     * @return bool
     */
    public function validate($value, array $payload): bool
    {
        /*
         * Logic to validate if entry is valid
         * true - valid
         * false - not valid
         */
        if ($value === null || $value === '') {
            return true;
        }

        foreach ($this->getValues() as $optionValue) {
            if (str_contains($value, $optionValue)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @return array
     */
    protected function getValues(): array
    {
        return $this->options[static::OPTION_VALUES];
    }
}
```

### src/Pyz/Zed/Process/Communication/Plugin/Validator/NotContainValidatorPlugin.php
```php
<?php

namespace Pyz\Zed\Process\Communication\Plugin\Validator;

use Pyz\Zed\Process\Business\Validator\Validators\NotContainValidator;
use SprykerMiddleware\Zed\Process\Communication\Plugin\Validator\AbstractGenericValidatorPlugin;

class NotContainValidatorPlugin extends AbstractGenericValidatorPlugin
{
    public const NAME = 'NotContain'; // Plugin identifier

    /**
     * @api
     *
     * @return string
     */
    public function getName(): string
    {
        return static::NAME;
    }

    /**
     * @api
     *
     * @return string
     */
    public function getValidatorClassName(): string
    {
        return NotContainValidator::class;
    }
}
```

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/ProductAbstractMiddlewareConnectorDependencyProvider.php
Now we will add the newly created plugin to the list of plugins available in our module:
```php
{...}
use Pyz\Zed\Process\Communication\Plugin\Validator\NotContainValidatorPlugin;
{...}
    public function getProductAbstractValidatorsPlugins(): array
    {
        return [
            new NotBlankValidatorPlugin(),
            new LengthValidatorPlugin(),
            new NotContainValidatorPlugin(),
        ];
    }
{...}
```

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Business/Validator/ValidationRuleSet/ProductAbstractValidationRuleSet.php
Everything is done and now you can use the plugin.
```php
{...}
    protected function getRules(): array
    {
        return [
            {...}
            'sku' => [
                [
                    'NotContain',
                    'options' => [
                        'values' => [
                            '#',
                            'test 5'
                        ]
                    ]
                ]
            ],
            {...}
        ];
    }
{...}
```

Apply the above change and run the CLI command again.
```shell
console middleware:process:run -p "PRODUCT_ABSTRACT_PROCESS" -i data/import/middleware/product_abstract.json -o data/import/middleware/out.json
```
This time, only entries 1 and 7 will be included in the output file.

# Mapper
Data validation is behind us.
Now it's time to map the remaining data so that the fields correspond to what we expect in Spryker.

We will start by preparing the configuration.

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Business/Mapper/Map/ProductAbstractMap.php
```php
<?php

namespace Pyz\Zed\ProductAbstractMiddlewareConnector\Business\Mapper\Map;

use SprykerMiddleware\Zed\Process\Business\Mapper\Map\AbstractMap;
use SprykerMiddleware\Zed\Process\Business\Mapper\Map\MapInterface;

class ProductAbstractMap extends AbstractMap
{
    /**
     * @return array
     */
    protected function getMap(): array
    {
        return [];
    }

    /**
     * @return string
     */
    protected function getStrategy(): string
    {
        return MapInterface::MAPPER_STRATEGY_COPY_UNKNOWN;
    }
}
```

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Business/ProductAbstractMiddlewareConnectorBusinessFactory.php
```php
{...}
use Pyz\Zed\ProductAbstractMiddlewareConnector\Business\Mapper\Map\ProductAbstractMap;
{...}
    /**
     * @return \SprykerMiddleware\Zed\Process\Business\Mapper\Map\MapInterface
     */
    public function createProductAbstractMap(): MapInterface
    {
        return new ProductAbstractMap();
    }
{...}
```

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Business/ProductAbstractMiddlewareConnectorFacadeInterface.php
```php
{...}
use Generated\Shared\Transfer\MapperConfigTransfer;
{...}
    /**
     * @return MapperConfigTransfer
     */
    public function getProductAbstractMapperConfig(): MapperConfigTransfer;
{...}
```

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Business/ProductAbstractMiddlewareConnectorFacade.php
```php
{...}
use Generated\Shared\Transfer\MapperConfigTransfer;
{...}
    /**
     * @return MapperConfigTransfer
     */
    public function getProductAbstractMapperConfig(): MapperConfigTransfer
    {
        return $this->getFactory()
            ->createProductAbstractMap()
            ->getMapperConfig();
    }
{...}
```

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Communication/Plugin/ProductAbstractMapperStagePlugin.php
```php
<?php

namespace Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\Plugin;

use Generated\Shared\Transfer\MapperConfigTransfer;
use Pyz\Zed\ProductAbstractMiddlewareConnector\Business\ProductAbstractMiddlewareConnectorFacadeInterface;
use Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\ProductAbstractMiddlewareConnectorCommunicationFactory;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface;

/**
 * @method ProductAbstractMiddlewareConnectorCommunicationFactory getFactory()
 * @method ProductAbstractMiddlewareConnectorFacadeInterface getFacade()
 */
class ProductAbstractMapperStagePlugin extends AbstractPlugin implements StagePluginInterface
{
    protected const PLUGIN_NAME = 'ProductAbstractMapperStagePlugin';

    /**
     * @return \Generated\Shared\Transfer\MapperConfigTransfer
     */
    protected function getMapperConfig(): MapperConfigTransfer
    {
        return $this->getFacade()
            ->getProductAbstractMapperConfig();
    }

    /**
     * @param mixed $payload
     * @param \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface $outStream
     * @param mixed $originalPayload
     *
     * @return mixed
     */
    public function process($payload, WriteStreamInterface $outStream, $originalPayload)
    {
        return $this->getFactory()
            ->getProcessFacade()
            ->map($payload, $this->getMapperConfig());
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return static::PLUGIN_NAME;
    }
}
```

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/ProductAbstractMiddlewareConnectorDependencyProvider.php
```php
{...}
use Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\Plugin\ProductAbstractMapperStagePlugin;
{...}
    protected function addProductAbstractTransformationProcessPlugins(Container $container): Container
    {
        {...}
        $container[static::PRODUCT_ABSTRACT_STAGE_PLUGIN_STACK] = function () {
            return [
                new StreamReaderStagePlugin(),
                new ProductAbstractValidatorStagePlugin(),
                new ProductAbstractMapperStagePlugin(),
                new StreamWriterStagePlugin(),
            ];
        };
        {...}
    }
{...}
```

The mapper configuration is ready, so it's time to define the mappings.

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Business/Mapper/Map/ProductAbstractMap.php
There are two functions in this file:
* `getMap()` - determines which field to map to which
* `getStrategy()` - specifies how unmapped fields are to be handled.
  There are 2 options:
  * `MAPPER_STRATEGY_COPY_UNKNOWN` - copies fields that have not been mapped
  * `MAPPER_STRATEGY_SKIP_UNKNOWN` - skips fields that have not been mapped

If you were to run the CLI command to run the middleware process right now, the resulting file would have the same data fields as the source file.
This is because we have `MAPPER_STRATEGY_COPY_UNKNOWN` set and `getMap()` has no mappings.

First, let's set the strategy to skip fields that we won't be mapping:
```php
{...}
    protected function getStrategy(): string
    {
        return MapInterface::MAPPER_STRATEGY_SKIP_UNKNOWN;
    }
{...}
```

Then we add a simple `keyMap Rules` mapping:
```php
{...}
    protected function getMap(): array
    {
        $keyMapRules = [
            'abstract_sku' => 'sku',
            'color_code' => 'kolor',
            'category_key' => 'type',
            'description.en_US' => 'desc',
            'description.de_DE' => 'desc',
        ];

        return $keyMapRules;
    }
{...}
```

We add the mapping in such a way that on the left side there is the name of the field that will be in the output file and on the right side there is the name of the field from the input file.
After processing, the resulting file should contain the following data:
```json
[
	{
		"abstract_sku": "cable test 1",
		"color_code": "red",
		"category_key": "przewody",
		"description": {
			"en_US": "Sample description of test cable 1.",
			"de_DE": "Sample description of test cable 1."
		}
	},
	{
		"abstract_sku": "cable test 7",
		"color_code": "white",
		"category_key": "przewody",
		"description": {
			"en_US": "Sample description of test cable 7.",
			"de_DE": "Sample description of test cable 7."
		}
	}
]
```

In addition to the simple `keyMapRules` mapping, we can also add a bit more advanced `closureMapRules` mappers:
```php
{...}
    protected function getMap(): array
    {
        {...}
        $closureMapRules = [
            'name.en_US' => function ($payload) {
                foreach ($payload['name'] as $name) {
                    if ($name['locale'] === 'en') {
                        return $name['name'];
                    }
                }
                return '';
            },
            'name.de_DE' => function ($payload) {
                foreach ($payload['name'] as $name) {
                    if ($name['locale'] === 'de') {
                        return $name['name'];
                    }
                }
                return '';
            },
            'url.en_US' => function ($payload) { return '/en/' . $payload['sku']; },
            'url.de_DE' => function ($payload) { return '/de/' . $payload['sku']; },
        ];

        return $closureMapRules;
    }
{...}
```

Here we use functions that take `$payload` as a parameter containing data from the entire entry that is currently being processed.
What the given function returns is treated as the value assigned to the mapped field.

In this case, the resulting file will look like this:
```json
[
	{
		"name": {
			"en_US": "Test Cable 1",
			"de_DE": "Tst Kabel 1"
		},
		"url": {
			"en_US": "/en/cable test 1",
			"de_DE": "/de/cable test 1"
		}
	},
	{
		"name": {
			"en_US": "Test Cable 7",
			"de_DE": "Tst Kabel 7"
		},
		"url": {
			"en_US": "/en/cable test 7",
			"de_DE": "/de/cable test 7"
		}
	}
]
```

Using the functions, we can also make the selected fields contain the hardcoded values:
```php
{...}
    protected function getMap(): array
    {
        {...}
        $hardcodedMapValues = [
            'category_product_order' => function ($payload) { return 0; },
            'tax_set_name'           => function ($payload) { return 'Standard Taxes'; },
            'localizedAttributes'    => function ($payload) { return []; },
            'new_from'               => function ($payload) { return null; },
            'new_to'                 => function ($payload) { return null; },
            'meta_title.en_US'       => function ($payload) { return 'Sample meta_title'; },
            'meta_title.de_DE'       => function ($payload) { return 'Sample meta_title'; },
            'meta_description.en_US' => function ($payload) { return 'Sample meta_description'; },
            'meta_description.de_DE' => function ($payload) { return 'Sample meta_description'; },
            'meta_keywords.en_US'    => function ($payload) { return 'Sample meta_keywords'; },
            'meta_keywords.de_DE'    => function ($payload) { return 'Sample meta_keywords'; },
        ];

        return $hardcodedMapValues;
    }
{...}
```

Output:
```json
[
	{
		"category_product_order": 0,
		"tax_set_name": "Standard Taxes",
		"localizedAttributes": [],
		"new_from": null,
		"new_to": null,
		"meta_title": {
			"en_US": "Sample meta_title",
			"de_DE": "Sample meta_title"
		},
		"meta_description": {
			"en_US": "Sample meta_description",
			"de_DE": "Sample meta_description"
		},
		"meta_keywords": {
			"en_US": "Sample meta_keywords",
			"de_DE": "Sample meta_keywords"
		}
	},
	{
		"category_product_order": 0,
		"tax_set_name": "Standard Taxes",
		"localizedAttributes": [],
		"new_from": null,
		"new_to": null,
		"meta_title": {
			"en_US": "Sample meta_title",
			"de_DE": "Sample meta_title"
		},
		"meta_description": {
			"en_US": "Sample meta_description",
			"de_DE": "Sample meta_description"
		},
		"meta_keywords": {
			"en_US": "Sample meta_keywords",
			"de_DE": "Sample meta_keywords"
		}
	}
]
```

For the purposes of further examples, we will add to this set a mapping of the `brand` attribute for `product-abstract` and combine all mappings together so that the file already contains all the fields needed for later import:
```php
{...}
    protected function getMap(): array
    {
        {...}
        $productAbstractAttributes = [
            'attribute_key_1' => function ($payload) { return 'brand'; },
            'value_1' => 'brand',
        ];

        return array_merge(
            $keyMapRules,
            $closureMapRules,
            $hardcodedMapValues,
            $productAbstractAttributes,
        );
    }
{...}
```

As a result, we get the following `out.json` file:
```json
[
	{
		"abstract_sku": "cable test 1",
		"color_code": "red",
		"category_key": "przewody",
		"description": {
			"en_US": "Sample description of test cable 1.",
			"de_DE": "Sample description of test cable 1."
		},
		"name": {
			"en_US": "Test Cable 1",
			"de_DE": "Tst Kabel 1"
		},
		"url": {
			"en_US": "/en/cable test 1",
			"de_DE": "/de/cable test 1"
		},
		"category_product_order": 0,
		"tax_set_name": "Standard Taxes",
		"localizedAttributes": [],
		"new_from": null,
		"new_to": null,
		"meta_title": {
			"en_US": "Sample meta_title",
			"de_DE": "Sample meta_title"
		},
		"meta_description": {
			"en_US": "Sample meta_description",
			"de_DE": "Sample meta_description"
		},
		"meta_keywords": {
			"en_US": "Sample meta_keywords",
			"de_DE": "Sample meta_keywords"
		},
		"attribute_key_1": "brand",
		"value_1": "HP"
	},
	{
		"abstract_sku": "cable test 7",
		"color_code": "white",
		"category_key": "przewody",
		"description": {
			"en_US": "Sample description of test cable 7.",
			"de_DE": "Sample description of test cable 7."
		},
		"name": {
			"en_US": "Test Cable 7",
			"de_DE": "Tst Kabel 7"
		},
		"url": {
			"en_US": "/en/cable test 7",
			"de_DE": "/de/cable test 7"
		},
		"category_product_order": 0,
		"tax_set_name": "Standard Taxes",
		"localizedAttributes": [],
		"new_from": null,
		"new_to": null,
		"meta_title": {
			"en_US": "Sample meta_title",
			"de_DE": "Sample meta_title"
		},
		"meta_description": {
			"en_US": "Sample meta_description",
			"de_DE": "Sample meta_description"
		},
		"meta_keywords": {
			"en_US": "Sample meta_keywords",
			"de_DE": "Sample meta_keywords"
		},
		"attribute_key_1": "brand",
		"value_1": "VGA"
	}
]
```

# Translator
Now that the data has been validated and mapped, there is one more problem to solve.
Some field values contain data in a different format than required, and others simply need to be translated into another language.

In such cases, a translator comes to the rescue.
However, before it can be used, it must be configured, as was the case with the mapper and validator.

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Business/Translator/Dictionary/ProductAbstractDictionary.php
```php
<?php

namespace Pyz\Zed\ProductAbstractMiddlewareConnector\Business\Translator\Dictionary;

use SprykerMiddleware\Zed\Process\Business\Translator\Dictionary\AbstractDictionary;

class ProductAbstractDictionary extends AbstractDictionary
{
    /**
     * @return array
     */
    public function getDictionary(): array
    {
        return [];
    }
}
```

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Business/ProductAbstractMiddlewareConnectorBusinessFactory.php
```php
{...}
use SprykerMiddleware\Zed\Process\Business\Translator\Dictionary\DictionaryInterface;
use Pyz\Zed\ProductAbstractMiddlewareConnector\Business\Translator\Dictionary\ProductAbstractDictionary;
{...}
    /**
     * @return \SprykerMiddleware\Zed\Process\Business\Translator\Dictionary\DictionaryInterface
     */
    public function createProductAbstractDictionary(): DictionaryInterface
    {
        return new ProductAbstractDictionary();
    }
{...}
```

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Business/ProductAbstractMiddlewareConnectorFacadeInterface.php
```php
{...}
use Generated\Shared\Transfer\TranslatorConfigTransfer;
{...}
    /**
     * @return TranslatorConfigTransfer
     */
    public function getProductAbstractTranslatorConfig(): TranslatorConfigTransfer;
{...}
```

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Business/ProductAbstractMiddlewareConnectorFacade.php
```php
{...}
use Generated\Shared\Transfer\TranslatorConfigTransfer;
{...}
    /**
     * @return TranslatorConfigTransfer
     */
    public function getProductAbstractTranslatorConfig(): TranslatorConfigTransfer
    {
        return $this->getFactory()
            ->createProductAbstractDictionary()
            ->getTranslatorConfig();
    }
{...}
```

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Communication/Plugin/ProductAbstractTranslationStagePlugin.php
```php
<?php

namespace Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\Plugin;

use Generated\Shared\Transfer\TranslatorConfigTransfer;
use Pyz\Zed\ProductAbstractMiddlewareConnector\Business\ProductAbstractMiddlewareConnectorFacadeInterface;
use Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\ProductAbstractMiddlewareConnectorCommunicationFactory;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\StagePluginInterface;

/**
 * @method ProductAbstractMiddlewareConnectorCommunicationFactory getFactory()
 * @method ProductAbstractMiddlewareConnectorFacadeInterface getFacade()
 */
class ProductAbstractTranslationStagePlugin extends AbstractPlugin implements StagePluginInterface
{
    protected const PLUGIN_NAME = 'ProductAbstractTranslationStagePlugin';

    /**
     * @return \Generated\Shared\Transfer\TranslatorConfigTransfer
     */
    protected function getTranslatorConfig(): TranslatorConfigTransfer
    {
        return $this->getFacade()
            ->getProductAbstractTranslatorConfig();
    }

    /**
     * @param mixed $payload
     * @param \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface $outStream
     * @param mixed $originalPayload
     *
     * @return mixed
     */
    public function process($payload, WriteStreamInterface $outStream, $originalPayload)
    {
        return $this->getFactory()
            ->getProcessFacade()
            ->translate($payload, $this->getTranslatorConfig());
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return static::PLUGIN_NAME;
    }
}
```

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/ProductAbstractMiddlewareConnectorDependencyProvider.php
```php
{...}
use Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\Plugin\ProductAbstractTranslationStagePlugin;
{...}
    public const PRODUCT_ABSTRACT_TRANSLATOR_FUNCTIONS = 'PRODUCT_ABSTRACT_TRANSLATOR_FUNCTIONS';
{...}
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        {...}
        $container = $this->addProductAbstractTranslatorFunctionsPlugins($container);

        return $container;
    }
{...}
    protected function addProductAbstractTransformationProcessPlugins(Container $container): Container
    {
        {...}
        $container[static::PRODUCT_ABSTRACT_STAGE_PLUGIN_STACK] = function () {
            return [
                new StreamReaderStagePlugin(),
                new ProductAbstractValidatorStagePlugin(),
                new ProductAbstractMapperStagePlugin(),
                new ProductAbstractTranslationStagePlugin(),
                new StreamWriterStagePlugin(),
            ];
        };
        {...}
    }
{...}
    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addProductAbstractTranslatorFunctionsPlugins($container): Container
    {
        $container[static::PRODUCT_ABSTRACT_TRANSLATOR_FUNCTIONS] = function () {
            return $this->getProductAbstractTranslatorFunctionPlugins();
        };
        return $container;
    }
{...}
    /**
     * @return \SprykerMiddleware\Zed\Process\Dependency\Plugin\TranslatorFunction\GenericTranslatorFunctionPluginInterface[]
     */
    public function getProductAbstractTranslatorFunctionPlugins(): array
    {
        return [];
    }
{...}
```

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Communication/ProductAbstractMiddlewareConnectorCommunicationFactory.php
```php
{...}
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\TranslatorFunctionInterface;
{...}
    /**
     * @return TranslatorFunctionInterface[]
     */
    public function getProductAbstractTranslatorFunctions(): array
    {
        return $this->getProvidedDependency(ProductAbstractMiddlewareConnectorDependencyProvider::PRODUCT_ABSTRACT_TRANSLATOR_FUNCTIONS);
    }
{...}
```

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Communication/Plugin/Configuration/ProductAbstractMiddlewareConnectorConfigurationProfilePlugin.php
```php
{...}
    public function getTranslatorFunctionPlugins(): array
    {
        return $this->getFactory()
            ->getProductAbstractTranslatorFunctions();
    }
{...}
```

This completes the configuration.
You are now ready to set specific translations.

## Values translation
Currently, in the `out.json` file we get the name of the `przewody` category.
In Spryker we don't have such a category, but its equivalent is the `cables` category.<br />
Knowing this, we can prepare an appropriate translation of the `category_key` field value.

Translations are done through translation plugins.
This particular plugin will rather only apply to this module, so we will add it directly in our module.

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Business/Translator/TranslatorFunction/PrzewodyToCables.php
```php
<?php

namespace Pyz\Zed\ProductAbstractMiddlewareConnector\Business\Translator\TranslatorFunction;

use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\AbstractTranslatorFunction;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\TranslatorFunctionInterface;

class PrzewodyToCables extends AbstractTranslatorFunction implements TranslatorFunctionInterface
{
    protected const TYPE_PRZEWODY = 'przewody';
    protected const TYPE_CABLES = 'cables';

    /**
     * @param mixed $value
     * @param array $payload
     *
     * @return mixed
     */
    public function translate($value, array $payload)
    {
        if ($value === static::TYPE_PRZEWODY) {
            return static::TYPE_CABLES;
        }

        return $value;
    }
}
```
Parameters accepted by the translate function:
* `$value` - contains the value that is in the checked field in the current iteration
* `$payload` - contains all fields from the given entry

The returned value is the value of the field after translation.

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Communication/Plugin/TranslatorFunction/PrzewodyToCablesTranslatorFunctionPlugin.php
```php
<?php

namespace Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\Plugin\TranslatorFunction;

use Pyz\Zed\ProductAbstractMiddlewareConnector\Business\Translator\TranslatorFunction\PrzewodyToCables;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\TranslatorFunctionInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\TranslatorFunction\GenericTranslatorFunctionPluginInterface;

class PrzewodyToCablesTranslatorFunctionPlugin extends AbstractPlugin implements GenericTranslatorFunctionPluginInterface
{
    protected const NAME = 'PrzewodyToCables';

    /**
     * @return string
     */
    public function getName(): string
    {
        return static::NAME;
    }

    /**
     * @return string
     */
    public function getTranslatorFunctionClassName(): string
    {
        return PrzewodyToCables::class;
    }

    /**
     * @param mixed $value
     * @param array $payload
     * @param string $key
     * @param array $options
     *
     * @return mixed
     */
    public function translate($value, array $payload, string $key, array $options)
    {
        /** @var TranslatorFunctionInterface $translator */
        $translatorClassName = $this->getTranslatorFunctionClassName();
        $translator = new $translatorClassName;

        return $translator->translate($value, $payload);
    }
}
```

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/ProductAbstractMiddlewareConnectorDependencyProvider.php
```php
{...}
use Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\Plugin\TranslatorFunction\PrzewodyToCablesTranslatorFunctionPlugin;
{...}
    public function getProductAbstractTranslatorFunctionPlugins(): array
    {
        return [
            new PrzewodyToCablesTranslatorFunctionPlugin(),
        ];
    }
{...}
```

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Business/Translator/Dictionary/ProductAbstractDictionary.php
```php
{...}
    public function getDictionary(): array
    {
        return [
            'category_key' => 'PrzewodyToCables',
        ];
    }
{...}
```

Run the following CLI command:
```shell
console middleware:process:run -p "PRODUCT_ABSTRACT_PROCESS" -i data/import/middleware/product_abstract.json -o data/import/middleware/out.json
```
This time, instead of `"category_key":"przewody",`, in the result file `"category_key":"cables",` will appear.

## Character replace
Another field that requires translation is the `sku` field.
The data we received contains a space symbol in the `sku` field, while the data we use should use a `-` character instead of a space.

Since this problem looks like something we may encounter with other modules as well, it will be worth preparing this plugin in the `Process` module, so that it is easily accessible to others.

### src/Pyz/Zed/Process/Business/Translator/TranslatorFunction/SpacesToDashes.php
```php
<?php

namespace Pyz\Zed\Process\Business\Translator\TranslatorFunction;

use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\AbstractTranslatorFunction;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\TranslatorFunctionInterface;

class SpacesToDashes extends AbstractTranslatorFunction implements TranslatorFunctionInterface
{
    protected const CHAR_SPACE = ' ';
    protected const CHAR_DASH = '-';

    /**
     * @param mixed $value
     * @param array $payload
     *
     * @return mixed
     */
    public function translate($value, array $payload)
    {
        return str_replace(static::CHAR_SPACE, static::CHAR_DASH, $value);
    }
}
```

### src/Pyz/Zed/Process/Communication/Plugin/TranslatorFunction/SpacesToDashesTranslatorFunctionPlugin.php
```php
<?php

namespace Pyz\Zed\Process\Communication\Plugin\TranslatorFunction;

use Pyz\Zed\Process\Business\Translator\TranslatorFunction\SpacesToDashes;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\TranslatorFunctionInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\TranslatorFunction\GenericTranslatorFunctionPluginInterface;

class SpacesToDashesTranslatorFunctionPlugin extends AbstractPlugin implements GenericTranslatorFunctionPluginInterface
{
    protected const NAME = 'SpacesToDashes';

    /**
     * @return string
     */
    public function getName(): string
    {
        return static::NAME;
    }

    /**
     * @return string
     */
    public function getTranslatorFunctionClassName(): string
    {
        return SpacesToDashes::class;
    }

    /**
     * @param mixed $value
     * @param array $payload
     * @param string $key
     * @param array $options
     *
     * @return mixed
     */
    public function translate($value, array $payload, string $key, array $options)
    {
        /** @var TranslatorFunctionInterface $translator */
        $translatorClassName = $this->getTranslatorFunctionClassName();
        $translator = new $translatorClassName;

        return $translator->translate($value, $payload);
    }
}
```

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/ProductAbstractMiddlewareConnectorDependencyProvider.php
```php
{...}
use Pyz\Zed\Process\Communication\Plugin\TranslatorFunction\SpacesToDashesTranslatorFunctionPlugin;
{...}
    public function getProductAbstractTranslatorFunctionPlugins(): array
    {
        return [
            new PrzewodyToCablesTranslatorFunctionPlugin(),
            new SpacesToDashesTranslatorFunctionPlugin(),
        ];
    }
{...}
```

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Business/Translator/Dictionary/ProductAbstractDictionary.php
```php
{...}
    public function getDictionary(): array
    {
        return [
            'category_key' => 'PrzewodyToCables',
            'abstract_sku' => 'SpacesToDashes',
        ];
    }
{...}
```

Run the following CLI command:
```shell
console middleware:process:run -p "PRODUCT_ABSTRACT_PROCESS" -i data/import/middleware/product_abstract.json -o data/import/middleware/out.json
```
This time, instead of `"abstract_sku":"cable test 1",`, in the result file `"abstract_sku":"cable-test-1",` will appear.

## Replacing values according to the list of values
The last thing we need to deal with is the colors.
The color we get in the source file is given in the form of words (`white`, `red`, etc.), and we need these values to be in the form of a hex code.

So we will create a translator that will translate word names into codes.
It seems that we can also use this functionality in many modules, so we will add this translator to the `Process` module as well.

### src/Pyz/Zed/Process/Business/Translator/TranslatorFunction/ColorsNameToColorsCode.php
```php
<?php

namespace Pyz\Zed\Process\Business\Translator\TranslatorFunction;

use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\AbstractTranslatorFunction;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\TranslatorFunctionInterface;

class ColorsNameToColorsCode extends AbstractTranslatorFunction implements TranslatorFunctionInterface
{
    protected const COLORS_NAME_CODE_ARRAY = [
        'white' => '#FFFFFF',
        'red'   => '#FF0000',
        'green' => '#00FF00',
        'blue'  => '#0000FF',
    ];

    /**
     * @param mixed $value
     * @param array $payload
     *
     * @return mixed
     */
    public function translate($value, array $payload)
    {
        if (array_key_exists($value, self::COLORS_NAME_CODE_ARRAY)) {
            return self::COLORS_NAME_CODE_ARRAY[$value];
        }

        return $value;
    }
}
```

### src/Pyz/Zed/Process/Communication/Plugin/TranslatorFunction/ColorsNameToColorsCodeTranslatorFunctionPlugin.php
```php
<?php

namespace Pyz\Zed\Process\Communication\Plugin\TranslatorFunction;

use Pyz\Zed\Process\Business\Translator\TranslatorFunction\ColorsNameToColorsCode;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\TranslatorFunctionInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\TranslatorFunction\GenericTranslatorFunctionPluginInterface;

class ColorsNameToColorsCodeTranslatorFunctionPlugin extends AbstractPlugin implements GenericTranslatorFunctionPluginInterface
{
    protected const NAME = 'ColorsNameToColorsCode';

    /**
     * @return string
     */
    public function getName(): string
    {
        return static::NAME;
    }

    /**
     * @return string
     */
    public function getTranslatorFunctionClassName(): string
    {
        return ColorsNameToColorsCode::class;
    }

    /**
     * @param mixed $value
     * @param array $payload
     * @param string $key
     * @param array $options
     *
     * @return mixed
     */
    public function translate($value, array $payload, string $key, array $options)
    {
        /** @var TranslatorFunctionInterface $translator */
        $translatorClassName = $this->getTranslatorFunctionClassName();
        $translator = new $translatorClassName;

        return $translator->translate($value, $payload);
    }
}
```

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/ProductAbstractMiddlewareConnectorDependencyProvider.php
```php
{...}
use Pyz\Zed\Process\Communication\Plugin\TranslatorFunction\ColorsNameToColorsCodeTranslatorFunctionPlugin;
{...}
    public function getProductAbstractTranslatorFunctionPlugins(): array
    {
        return [
            new PrzewodyToCablesTranslatorFunctionPlugin(),
            new SpacesToDashesTranslatorFunctionPlugin(),
            new ColorsNameToColorsCodeTranslatorFunctionPlugin(),
        ];
    }
{...}
```

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Business/Translator/Dictionary/ProductAbstractDictionary.php
```php
{...}
    public function getDictionary(): array
    {
        return [
            'category_key' => 'PrzewodyToCables',
            'abstract_sku' => 'SpacesToDashes',
            'color_code'   => 'ColorsNameToColorsCode',
        ];
    }
{...}
```

# Importer
The data is prepared and saved to a file.
Now we'll want to import this dataset.

The importer will be divided into two parts.
First, we will add a new `OutputStreamPlugin` plugin in the `Process` module. Thanks to this, it will be possible to perform the import action not only in our module, but also in any other.
Then, to the `ProductAbstractMiddlewareConnector` module, we will add the correct importer that will import the `product-abstract` data.

## Generic import plugin
### src/Pyz/Zed/Process/Dependency/Plugin/Importer/DataImporterPluginInterface.php
```php
<?php

namespace Pyz\Zed\Process\Dependency\Plugin\Importer;

interface DataImporterPluginInterface
{
    /**
     * @param array $data
     *
     * @return void
     */
    public function import(array $data): void;
}
```

### src/Pyz/Zed/Process/Business/Stream/DataImportWriteStream.php
```php
<?php

namespace Pyz\Zed\Process\Business\Stream;

use Pyz\Zed\Process\Dependency\Plugin\Importer\DataImporterPluginInterface;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;
use SprykerMiddleware\Zed\Process\Business\Exception\MethodNotSupportedException;

class DataImportWriteStream implements WriteStreamInterface
{
    /**
     * @var DataImporterPluginInterface
     */
    protected $dataImporterPlugin;

    /**
     * @var array
     */
    protected $data = [];

    /**
     * @param DataImporterPluginInterface $dataImporterPlugin
     */
    public function __construct(DataImporterPluginInterface $dataImporterPlugin)
    {
        $this->dataImporterPlugin = $dataImporterPlugin;
    }

    /**
     * @return bool
     */
    public function open(): bool
    {
        $this->data = [];
        return true;
    }

    /**
     * @return bool
     */
    public function close(): bool
    {
        return true;
    }

    /**
     * @param int $offset
     * @param int $whence
     *
     * @return int
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\MethodNotSupportedException
     *
     */
    public function seek(int $offset, int $whence): int
    {
        throw new MethodNotSupportedException();
    }

    /**
     * @return bool
     * @throws \SprykerMiddleware\Zed\Process\Business\Exception\MethodNotSupportedException
     *
     */
    public function eof(): bool
    {
        throw new MethodNotSupportedException();
    }

    /**
     * @param array $data
     *
     * @return int
     */
    public function write(array $data): int
    {
        $this->data[] = $data;
        return 1;
    }

    /**
     * @return bool
     */
    public function flush(): bool
    {
        $this->dataImporterPlugin->import($this->data);
        return true;
    }
}
```

### src/Pyz/Zed/Process/Business/Stream/StreamFactoryInterface.php
```php
<?php

namespace Pyz\Zed\Process\Business\Stream;

use Pyz\Zed\Process\Dependency\Plugin\Importer\DataImporterPluginInterface;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;
use SprykerMiddleware\Zed\Process\Business\Stream\StreamFactoryInterface as SprykerStreamFactoryInterface;

interface StreamFactoryInterface extends SprykerStreamFactoryInterface
{
    /**
     * @param DataImporterPluginInterface $dataImporterPlugin
     *
     * @return \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface
     */
    public function createDataImportWriteStream(DataImporterPluginInterface $dataImporterPlugin): WriteStreamInterface;
}
```

### src/Pyz/Zed/Process/Business/Stream/StreamFactory.php
```php
<?php

namespace Pyz\Zed\Process\Business\Stream;

use Pyz\Zed\Process\Dependency\Plugin\Importer\DataImporterPluginInterface;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;
use SprykerMiddleware\Zed\Process\Business\Stream\StreamFactory as SprykerStreamFactory;

class StreamFactory extends SprykerStreamFactory implements StreamFactoryInterface
{
    /**
     * @param DataImporterPluginInterface $dataImporterPlugin
     * @return WriteStreamInterface
     */
    public function createDataImportWriteStream(DataImporterPluginInterface $dataImporterPlugin): WriteStreamInterface
    {
        return new DataImportWriteStream($dataImporterPlugin);
    }
}
```

### src/Pyz/Zed/Process/Business/Importer/ImporterInterface.php
```php
<?php

namespace Pyz\Zed\Process\Business\Importer;

interface ImporterInterface
{
    /**
     * @param array $data
     *
     * @return void
     */
    public function import(array $data): void;
}
```

## Plugin importu

###  src/Pyz/Zed/ProductAbstractMiddlewareConnector/Business/Importer/Importer.php
```php
<?php

namespace Pyz\Zed\ProductAbstractMiddlewareConnector\Business\Importer;

use Pyz\Zed\Process\Business\Importer\ImporterInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerInterface;
use Spryker\Zed\DataImport\Business\Model\Publisher\DataImporterPublisherInterface;
use Spryker\Zed\EventBehavior\EventBehaviorConfig;

class Importer implements ImporterInterface
{
    /**
     * @var \Spryker\Zed\DataImport\Business\Model\Publisher\DataImporterPublisherInterface
     */
    protected $dataImporterPublisher;

    /**
     * @var \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerInterface
     */
    private $dataSetStepBroker;

    /**
     * @var \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface
     */
    private $dataSet;

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\Publisher\DataImporterPublisherInterface $dataImporterPublisher
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerInterface $dataSetStepBroker
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     */
    public function __construct(
        DataImporterPublisherInterface $dataImporterPublisher,
        DataSetStepBrokerInterface $dataSetStepBroker,
        DataSetInterface $dataSet
    ) {
        $this->dataImporterPublisher = $dataImporterPublisher;
        $this->dataSetStepBroker = $dataSetStepBroker;
        $this->dataSet = $dataSet;
    }

    /**
     * @param array $data
     *
     * @return void
     */
    public function import(array $data): void
    {
        EventBehaviorConfig::disableEvent();
        foreach ($data as $item) {
            $this->dataSet->exchangeArray($item);
            $this->dataSetStepBroker->execute($this->dataSet);
        }

        EventBehaviorConfig::enableEvent();
        $this->dataImporterPublisher->triggerEvents();
    }
}
```

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Business/Importer/ImporterSteps/AddProductAbstractLocalizedAttributesStep.php
During the import, an additional step will be needed to complete the product attributes from the received data.
This step is specific in this case and applies to `product-abstract`.
In other modules, such a modification may be unnecessary.
```php
<?php

namespace Pyz\Zed\ProductAbstractMiddlewareConnector\Business\Importer\ImporterSteps;

use Spryker\Zed\DataImport\Business\Model\DataImportStep\DataImportStepInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;

class AddProductAbstractLocalizedAttributesStep implements DataImportStepInterface
{
    public const KEY_LOCALES = 'locales';

    public const LOCALIZED_KEYS = [
        'name',
        'description',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'url',
    ];

    /**
     * @param \Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface $dataSet
     *
     * @return void
     */
    public function execute(DataSetInterface $dataSet): void
    {
        $this->addDataSetLocalizedValues($dataSet);
    }

    /**
     * @param DataSetInterface $dataSet
     *
     * @return void
     */
    protected function addDataSetLocalizedValues(DataSetInterface $dataSet): void
    {
        foreach (self::LOCALIZED_KEYS as $key) {
            if ($dataSet[$key]) {
                $this->addDataSetLocalizedValuesByKey($dataSet, $key);
            }
        }
    }

    /**
     * @param DataSetInterface $dataSet
     * @param string $key
     *
     * @return void
     */
    protected function addDataSetLocalizedValuesByKey(DataSetInterface $dataSet, string $key): void
    {
        foreach ($dataSet[self::KEY_LOCALES] as $localeKey => $localeValue) {
            if (array_key_exists($localeKey, $dataSet[$key])) {
                $dataSet[$key . '.' . $localeKey] = $dataSet[$key][$localeKey];
            }
        }
    }
}
```

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Business/ProductAbstractMiddlewareConnectorBusinessFactory.php
```php
{...}
use Pyz\Zed\DataImport\Business\DataImportBusinessFactory;
use Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepository;
use Pyz\Zed\DataImport\Business\Model\Product\Repository\ProductRepositoryInterface;
use Pyz\Zed\Process\Business\Importer\ImporterInterface;
use Pyz\Zed\ProductAbstractMiddlewareConnector\Business\Importer\Importer;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetInterface;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSet;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBroker;
use Spryker\Zed\DataImport\Business\Model\DataSet\DataSetStepBrokerInterface;
use Pyz\Zed\DataImport\Business\Model\ProductAbstract\ProductAbstractHydratorStep;
use Pyz\Zed\DataImport\Business\Model\ProductAbstract\ProductAbstractWriterStep;
use Spryker\Zed\DataImport\Business\Model\Publisher\DataImporterPublisherInterface;
use Spryker\Zed\DataImport\Business\Model\Publisher\DataImporterPublisher;
use Pyz\Zed\ProductAbstractMiddlewareConnector\Business\Importer\ImporterSteps\AddProductAbstractLocalizedAttributesStep;
{...}
    /**
     * @return ImporterInterface
     */
    public function createProductAbstractImporter(): ImporterInterface
    {
        return new Importer(
            $this->createDataImporterPublisher(),
            $this->createProductAbstractImportDataSetStepBroker(),
            $this->createDataSet()
        );
    }

    /**
     * @return DataImporterPublisherInterface
     */
    protected function createDataImporterPublisher(): DataImporterPublisherInterface
    {
        return new DataImporterPublisher();
    }

    /**
     * @return DataSetInterface
     */
    protected function createDataSet(): DataSetInterface
    {
        return new DataSet();
    }

    /**
     * @return DataSetStepBrokerInterface
     */
    protected function createProductAbstractImportDataSetStepBroker(): DataSetStepBrokerInterface
    {
        $dataSetStepBroker = new DataSetStepBroker();

        $dataImportBusinessFactory = $this->createDataImportBusinessFactory();

        $dataSetStepBroker
            ->addStep($dataImportBusinessFactory->createProductAbstractCheckExistenceStep())
            ->addStep($dataImportBusinessFactory->createAddLocalesStep())
            ->addStep($dataImportBusinessFactory->createAddCategoryKeysStep())
            ->addStep($this->createAddProductAbstractLocalizedAttributesStep())
            ->addStep($dataImportBusinessFactory->createTaxSetNameToIdTaxSetStep(ProductAbstractHydratorStep::COLUMN_TAX_SET_NAME))
            ->addStep($dataImportBusinessFactory->createAttributesExtractorStep())
            ->addStep($dataImportBusinessFactory->createProductLocalizedAttributesExtractorStep([
                ProductAbstractHydratorStep::COLUMN_NAME,
                ProductAbstractHydratorStep::COLUMN_URL,
                ProductAbstractHydratorStep::COLUMN_DESCRIPTION,
                ProductAbstractHydratorStep::COLUMN_META_TITLE,
                ProductAbstractHydratorStep::COLUMN_META_DESCRIPTION,
                ProductAbstractHydratorStep::COLUMN_META_KEYWORDS,
            ]))
            ->addStep(new ProductAbstractHydratorStep())
            ->addStep($this->createProductAbstractWriteStep());

        return $dataSetStepBroker;
    }

    /**
     * @return DataImportBusinessFactory
     */
    public function createDataImportBusinessFactory(): DataImportBusinessFactory
    {
        return new DataImportBusinessFactory();
    }

    /**
     * @return AddProductAbstractLocalizedAttributesStep
     */
    public function createAddProductAbstractLocalizedAttributesStep(): AddProductAbstractLocalizedAttributesStep
    {
        return new AddProductAbstractLocalizedAttributesStep();
    }

    /**
     * @return ProductAbstractWriterStep
     */
    protected function createProductAbstractWriteStep(): ProductAbstractWriterStep
    {
        return new ProductAbstractWriterStep($this->createProductRepository());
    }

    /**
     * @return ProductRepositoryInterface
     */
    protected function createProductRepository(): ProductRepositoryInterface
    {
        return new ProductRepository();
    }
{...}
```

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Business/ProductAbstractMiddlewareConnectorFacadeInterface.php
```php
{...}
use Pyz\Zed\Process\Business\Importer\ImporterInterface;
{...}
    /**
     * @return ImporterInterface
     */
    public function getProductAbstractImporter(): ImporterInterface;
{...}
```

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Business/ProductAbstractMiddlewareConnectorFacade.php
```php
{...}
use Pyz\Zed\Process\Business\Importer\ImporterInterface;
{...}
    /**
     * @return ImporterInterface
     */
    public function getProductAbstractImporter(): ImporterInterface
    {
        return $this->getFactory()->createProductAbstractImporter();
    }
{...}
```

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Communication/Plugin/Importer/ProductAbstractDataImporterPlugin.php
```php
<?php

namespace Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\Plugin\Importer;

use Pyz\Zed\Process\Dependency\Plugin\Importer\DataImporterPluginInterface;
use Pyz\Zed\ProductAbstractMiddlewareConnector\Business\ProductAbstractMiddlewareConnectorFacadeInterface;
use Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\ProductAbstractMiddlewareConnectorCommunicationFactory;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method ProductAbstractMiddlewareConnectorCommunicationFactory getFactory()
 * @method ProductAbstractMiddlewareConnectorFacadeInterface getFacade()
 */
class ProductAbstractDataImporterPlugin extends AbstractPlugin implements DataImporterPluginInterface
{
    /**
     * @param array $data
     *
     * @return void
     */
    public function import(array $data): void
    {
        $this->getFacade()->getProductAbstractImporter()->import($data);
    }
}
```

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Communication/ProductAbstractMiddlewareConnectorCommunicationFactory.php
```php
{...}
use Pyz\Zed\Process\Business\Stream\StreamFactory;
use Pyz\Zed\Process\Business\Stream\StreamFactoryInterface;
{...}
    /**
     * @return StreamFactoryInterface
     */
    public function createStreamFactory(): StreamFactoryInterface
    {
        return new StreamFactory();
    }
{...}
```

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/Communication/Plugin/Stream/ProductAbstractDataImportOutputStreamPlugin.php
```php
<?php

namespace Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\Plugin\Stream;

use Pyz\Zed\ProductAbstractMiddlewareConnector\Business\ProductAbstractMiddlewareConnectorFacadeInterface;
use Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\Plugin\Importer\ProductAbstractDataImporterPlugin;
use Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\ProductAbstractMiddlewareConnectorCommunicationFactory;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\Stream\OutputStreamPluginInterface;

/**
 * @method ProductAbstractMiddlewareConnectorCommunicationFactory getFactory()
 * @method ProductAbstractMiddlewareConnectorFacadeInterface getFacade()
 */
class ProductAbstractDataImportOutputStreamPlugin extends AbstractPlugin implements OutputStreamPluginInterface
{
    protected const PLUGIN_NAME = 'ProductAbstractDataImportOutputStreamPlugin';

    /**
     * @return string
     */
    public function getName(): string
    {
        return static::PLUGIN_NAME;
    }

    /**
     * @param string $path
     *
     * @return \SprykerMiddleware\Shared\Process\Stream\WriteStreamInterface
     */
    public function getOutputStream(string $path): WriteStreamInterface
    {
        $dataImporterPlugin = new ProductAbstractDataImporterPlugin();

        return $this->getFactory()
            ->createStreamFactory()
            ->createDataImportWriteStream($dataImporterPlugin);
    }
}
```

### src/Pyz/Zed/ProductAbstractMiddlewareConnector/ProductAbstractMiddlewareConnectorDependencyProvider.php
```php
{...}
use Pyz\Zed\ProductAbstractMiddlewareConnector\Communication\Plugin\Stream\ProductAbstractDataImportOutputStreamPlugin;
{...}
    protected function addProductAbstractTransformationProcessPlugins(Container $container): Container
    {
        {...}
        $container[static::PRODUCT_ABSTRACT_OUTPUT_STREAM_PLUGIN] = function () {
            return new ProductAbstractDataImportOutputStreamPlugin();
        };
        {...}
    }
{...}
```

## Verification
Run the command below in the CLI:
```shell
console middleware:process:run -p "PRODUCT_ABSTRACT_PROCESS" -i data/import/middleware/product_abstract.json
```
This time, we do not specify the parameter containing the path to the output file, because instead of writing to the file, we have imported the data.

After logging into RabbitMQ, two additional entries appeared in the `publish.product_abstract` queue.

In addition, you can see the imported data in the database by executing the following query:
```sql
SELECT sppa.id_product_abstract,
       sppa.sku,
       sppa.pyz_color_code,
       spal.name,
       spal.description,
       sppa.attributes
  FROM spy_product_abstract sppa
  LEFT JOIN spy_product_abstract_localized_attributes spal ON spal.fk_product_abstract = sppa.id_product_abstract
 WHERE sppa.sku like 'cable-test-%'
```
As a result we get a table like this:

id_product_abstract | sku | pyz_color_code | name | description | attributes
--- | --- | --- | --- | --- | ---
423 | cable-test-1 | #FF0000 | Tst Kabel 1 | Sample description of test cable 1. | {"brand":"HP"}
423 | cable-test-1 | #FF0000 | Test Cable 1 | Sample description of test cable 1. | {"brand":"HP"}
424 | cable-test-7 | #FFFFFF | Tst Kabel 7 | Sample description of test cable 7. | "{""brand"":""VGA""}"
424 | cable-test-7 | #FFFFFF | Test Cable 7 | Sample description of test cable 7. | "{""brand"":""VGA""}"
