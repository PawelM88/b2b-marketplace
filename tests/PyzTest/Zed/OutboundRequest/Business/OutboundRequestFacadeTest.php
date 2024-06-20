<?php

namespace PyzTest\Zed\OutboundRequest\Business;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\OutboundRequestTransfer;
use Pyz\Zed\OutboundRequest\Business\OutboundRequestFacadeInterface;
use Pyz\Zed\OutboundRequest\OutboundRequestConfig;
use SprykerTest\Shared\Testify\Helper\LocatorHelperTrait;

class OutboundRequestFacadeTest extends Unit
{
    use LocatorHelperTrait;

    /**
     * @return void
     */
    public function testCallOutboundRequestSuccess(): void
    {
        // Arrange
        $outboundRequestTransfer = new OutboundRequestTransfer();
        $outboundRequestTransfer->setMethod((new OutboundRequestConfig)->getOutboundRequestDefaultMethod())
            ->setUri((new OutboundRequestConfig)->getOutboundRequestDataUrl());

        // Act
        $outboundHttpResponse = $this->getOutboundRequestFacade()->callOutboundRequest(
            $outboundRequestTransfer
        );

        // Assert
        $this->assertNotEmpty($outboundHttpResponse->getData());
        $this->assertIsNotArray($outboundHttpResponse->getData());
        $this->assertIsNotString($outboundHttpResponse->getData());
        $this->assertIsObject($outboundHttpResponse->getData());
    }

    /**
     * @return \Pyz\Zed\OutboundRequest\Business\OutboundRequestFacadeInterface
     */
    protected function getOutboundRequestFacade(): OutboundRequestFacadeInterface
    {
        return $this->getLocator()->outboundRequest()->facade();
    }
}
