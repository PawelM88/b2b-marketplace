<?php

namespace Pyz\Zed\CompanyUserMiddlewareConnector\Business\Validator\ValidationRuleSet;

use SprykerMiddleware\Zed\Process\Business\Validator\ValidationRuleSet\AbstractValidationRuleSet;

class CompanyUserValidationRuleSet extends AbstractValidationRuleSet
{
    /**
     * @return array
     */
    protected function getRules(): array
    {
        return [
            'customer_number' => ['NotBlank'],
            'company_user_signature' => [
                ['NotContain', 'options' => ['values' => ['#', '$']]]
            ],
            'company_signature' => [['Length', 'options' => ['max' => 15]]]
        ];
    }
}
