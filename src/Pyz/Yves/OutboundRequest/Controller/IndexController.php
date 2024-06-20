<?php

namespace Pyz\Yves\OutboundRequest\Controller;

use Generated\Shared\Transfer\OutboundRequestTransfer;
use Spryker\Yves\Kernel\Controller\AbstractController;
use Spryker\Yves\Kernel\View\View;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Client\OutboundRequest\OutboundRequestClientInterface getClient()
 */
class IndexController extends AbstractController
{
    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Spryker\Yves\Kernel\View\View
     */
    public function indexAction(Request $request): View
    {
        $outboundRequest = new OutboundRequestTransfer();

        $outboundRequestTransfer = $this->getClient()->callOutboundRequest(
            $outboundRequest
        );
        $data = ['outboundRequest' => $outboundRequestTransfer->getData()];

        return $this->view(
            $data,
            [],
            '@OutboundRequest/views/index/index.twig'
        );
    }
}
