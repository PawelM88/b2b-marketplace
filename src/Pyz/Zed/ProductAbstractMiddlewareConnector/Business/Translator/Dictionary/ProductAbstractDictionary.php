<?php

declare(strict_types=1);

namespace Pyz\Zed\ProductAbstractMiddlewareConnector\Business\Translator\Dictionary;

use SprykerMiddleware\Zed\Process\Business\Translator\Dictionary\AbstractDictionary;

class ProductAbstractDictionary extends AbstractDictionary
{
    /**
     * @return array<string>
     */
    public function getDictionary(): array
    {
        return [
            'category_key' => 'PrzewodyToCables',
            'abstract_sku' => 'SpacesToDashes',
            'color_code' => 'ColorsNameToColorsCode',
        ];
    }
}
