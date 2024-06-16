<?php

declare(strict_types=1);

namespace Pyz\Zed\ProductAbstractMiddlewareConnector\Business\Validator\ValidationRuleSet;

use SprykerMiddleware\Zed\Process\Business\Validator\ValidationRuleSet\AbstractValidationRuleSet;

class ProductAbstractValidationRuleSet extends AbstractValidationRuleSet
{
    /**
     * @return array<mixed>
     */
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
            'sku' => [
                [
                    'NotContain',
                    'options' => [
                        'values' => [
                            '#',
                            'test 5',
                        ],
                    ],
                ],
            ],
            'type' => function ($value, $payload) {
                return (bool)$value;
            },
        ];
    }
}
