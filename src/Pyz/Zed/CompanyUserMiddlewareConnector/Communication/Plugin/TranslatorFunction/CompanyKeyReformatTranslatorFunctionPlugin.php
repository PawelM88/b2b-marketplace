<?php

namespace Pyz\Zed\CompanyUserMiddlewareConnector\Communication\Plugin\TranslatorFunction;

use Pyz\Zed\CompanyUserMiddlewareConnector\Business\Translator\TranslatorFunction\CompanyKeyReformat;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use SprykerMiddleware\Zed\Process\Business\Translator\TranslatorFunction\TranslatorFunctionInterface;
use SprykerMiddleware\Zed\Process\Dependency\Plugin\TranslatorFunction\GenericTranslatorFunctionPluginInterface;

class CompanyKeyReformatTranslatorFunctionPlugin extends AbstractPlugin implements
    GenericTranslatorFunctionPluginInterface
{
    /**
     * @var string
     */
    protected const NAME = 'CompanyKeyReformat';

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
        return CompanyKeyReformat::class;
    }

    /**
     * @param mixed $value
     * @param array $payload
     * @param string $key
     * @param array $options
     *
     * @return mixed
     */
    public function translate($value, array $payload, string $key, array $options): mixed
    {
        /** @var TranslatorFunctionInterface $translator */
        $translatorClassName = $this->getTranslatorFunctionClassName();
        $translator = new $translatorClassName;

        return $translator->translate($value, $payload);
    }
}
