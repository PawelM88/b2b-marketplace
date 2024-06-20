<?php

namespace Pyz\Zed\CompanyUserMiddlewareConnector\Business\Translator\Dictionary;

use SprykerMiddleware\Zed\Process\Business\Translator\Dictionary\AbstractDictionary;

class CompanyUserDictionary extends AbstractDictionary
{
    /**
     * @return array
     */
    public function getDictionary(): array
    {
        return [
            'company_user_key' => 'UserRemove',
            'customer_reference' => 'CountryNamePlToDe',
            'company_key' => 'CompanyKeyReformat',
        ];
    }
}
