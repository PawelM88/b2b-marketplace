<?php

declare(strict_types=1);

namespace Pyz\Zed\ProductAbstractMiddlewareConnector\Business\Mapper\Map;

use SprykerMiddleware\Zed\Process\Business\Mapper\Map\AbstractMap;
use SprykerMiddleware\Zed\Process\Business\Mapper\Map\MapInterface;

class ProductAbstractMap extends AbstractMap
{
    /**
     * @return array<mixed>
     */
    protected function getMap(): array
    {
        $keyMapRules = [
            'abstract_sku' => 'sku',
            'color_code' => 'kolor',
            'category_key' => 'type',
            'description.en_US' => 'desc',
            'description.de_DE' => 'desc',
        ];

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
            'url.en_US' => function ($payload) {
                return '/en/' . $payload['sku'];
            },
            'url.de_DE' => function ($payload) {
                return '/de/' . $payload['sku'];
            },
        ];

        $hardcodedMapValues = [
            'category_product_order' => function ($payload) {
                return 0;
            },
            'tax_set_name' => function ($payload) {
                return 'Standard Taxes';
            },
            'localizedAttributes' => function ($payload) {
                return [];
            },
            'new_from' => function ($payload) {
                return null;
            },
            'new_to' => function ($payload) {
                return null;
            },
            'meta_title.en_US' => function ($payload) {
                return 'Sample meta_title';
            },
            'meta_title.de_DE' => function ($payload) {
                return 'Sample meta_title';
            },
            'meta_description.en_US' => function ($payload) {
                return 'Sample meta_description';
            },
            'meta_description.de_DE' => function ($payload) {
                return 'Sample meta_description';
            },
            'meta_keywords.en_US' => function ($payload) {
                return 'Sample meta_keywords';
            },
            'meta_keywords.de_DE' => function ($payload) {
                return 'Sample meta_keywords';
            },
        ];

        $productAbstractAttributes = [
            'attribute_key_1' => function ($payload) {
                return 'brand';
            },
            'value_1' => 'brand',
        ];

        return array_merge(
            $keyMapRules,
            $closureMapRules,
            $hardcodedMapValues,
            $productAbstractAttributes,
        );
    }

    /**
     * @return string
     */
    protected function getStrategy(): string
    {
        return MapInterface::MAPPER_STRATEGY_SKIP_UNKNOWN;
    }
}
