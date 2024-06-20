<?php

namespace Pyz\Zed\CompanyUserMiddlewareConnector\Business\Mapper\Map;

use SprykerMiddleware\Zed\Process\Business\Mapper\Map\AbstractMap;
use SprykerMiddleware\Zed\Process\Business\Mapper\Map\MapInterface;

class CompanyUserMap extends AbstractMap
{
    /**
     * @return array
     */
    protected function getMap(): array
    {
        $keyMapRules = [
            'company_user_key' => 'company_user_signature',
            'customer_reference' => 'customer_number',
            'company_key' => 'company_signature',
        ];

        $hardcodedMapValues = [
            'is_default' => function ($payload) {
                return null;
            }
        ];

        return array_merge(
            $keyMapRules,
            $hardcodedMapValues,
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
