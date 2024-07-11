<?php

declare(strict_types=1);

namespace Pyz\Zed\TermConsent\Business;

use Pyz\Zed\Term\Business\TermFacadeInterface;
use Pyz\Zed\TermConsent\Business\TermConsent\TermConsentReader;
use Pyz\Zed\TermConsent\Business\TermConsent\TermConsentReaderInterface;
use Pyz\Zed\TermConsent\Business\TermConsent\TermConsentSaver;
use Pyz\Zed\TermConsent\Business\TermConsent\TermConsentSaverInterface;
use Pyz\Zed\TermConsent\Business\TermConsent\TermConsentValidator;
use Pyz\Zed\TermConsent\Business\TermConsent\TermConsentValidatorInterface;
use Pyz\Zed\TermConsent\Persistence\Mapper\TermConsentMapper;
use Pyz\Zed\TermConsent\Persistence\Mapper\TermConsentMapperInterface;
use Pyz\Zed\TermConsent\TermConsentDependencyProvider;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Pyz\Zed\TermConsent\Persistence\TermConsentRepositoryInterface getRepository()
 * @method \Pyz\Zed\TermConsent\Persistence\TermConsentEntityManagerInterface getEntityManager()
 */
class TermConsentBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Zed\TermConsent\Business\TermConsent\TermConsentReaderInterface
     */
    public function createTermConsentReader(): TermConsentReaderInterface
    {
        return new TermConsentReader(
            $this->getRepository(),
            $this->getTermFacade(),
            $this->createTermConsentValidator(),
            $this->createTermConsentMapper(),
        );
    }

    /**
     * @return \Pyz\Zed\TermConsent\Business\TermConsent\TermConsentSaverInterface
     */
    public function createTermConsentSaver(): TermConsentSaverInterface
    {
        return new TermConsentSaver($this->getEntityManager());
    }

    /**
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException !
     *
     * @return \Pyz\Zed\Term\Business\TermFacadeInterface
     */
    protected function getTermFacade(): TermFacadeInterface
    {
        return $this->getProvidedDependency(TermConsentDependencyProvider::TERM_FACADE);
    }

    /**
     * @return \Pyz\Zed\TermConsent\Business\TermConsent\TermConsentValidatorInterface
     */
    protected function createTermConsentValidator(): TermConsentValidatorInterface
    {
        return new TermConsentValidator();
    }

    /**
     * @return \Pyz\Zed\TermConsent\Persistence\Mapper\TermConsentMapperInterface
     */
    protected function createTermConsentMapper(): TermConsentMapperInterface
    {
        return new TermConsentMapper();
    }
}
