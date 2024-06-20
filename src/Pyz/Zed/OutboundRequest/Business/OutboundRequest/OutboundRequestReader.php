<?php

namespace Pyz\Zed\OutboundRequest\Business\OutboundRequest;

use Generated\Shared\Transfer\OutboundHttpResponseTransfer;
use Generated\Shared\Transfer\OutboundRequestTransfer;
use Generated\Shared\Transfer\OutboundResponseCollectionTransfer;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Pyz\Zed\OutboundRequest\Business\Mapper\OutboundRequestMapper;
use Pyz\Zed\OutboundRequest\OutboundRequestConfig;
use Spryker\Shared\Log\LoggerTrait;
use Spryker\Zed\Log\Communication\Plugin\ZedLoggerConfigPlugin;

class OutboundRequestReader implements OutboundRequestReaderInterface
{
    use LoggerTrait;

    /**
     * @var \Pyz\Zed\OutboundRequest\OutboundRequestConfig
     */
    protected OutboundRequestConfig $config;

    /**
     * @var \GuzzleHttp\ClientInterface
     */
    protected ClientInterface $client;

    /**
     * @var \Pyz\Zed\OutboundRequest\Business\Mapper\OutboundRequestMapper
     */
    protected OutboundRequestMapper $outboundRequestMapper;

    /**
     * @param \Pyz\Zed\OutboundRequest\OutboundRequestConfig $config
     * @param \GuzzleHttp\ClientInterface $client
     * @param \Pyz\Zed\OutboundRequest\Business\Mapper\OutboundRequestMapper $outboundRequestMapper
     */
    public function __construct(
        OutboundRequestConfig $config,
        ClientInterface $client,
        OutboundRequestMapper $outboundRequestMapper
    ) {
        $this->config = $config;
        $this->client = $client;
        $this->outboundRequestMapper = $outboundRequestMapper;
    }

    /**
     * @param \Generated\Shared\Transfer\OutboundRequestTransfer $outboundRequestTransfer
     *
     * @throws \GuzzleHttp\Exception\GuzzleException !
     *
     * @return \Generated\Shared\Transfer\OutboundResponseCollectionTransfer
     */
    public function doOutboundRequest(OutboundRequestTransfer $outboundRequestTransfer
    ): OutboundResponseCollectionTransfer {
        $requestUri = $outboundRequestTransfer->getUri() ?? $this->config->getOutboundRequestDataUrl();
        $method = $outboundRequestTransfer->getMethod() ?? $this->config->getOutboundRequestDefaultMethod();

        try {
            $apiResponse = $this->executeRequest($method, $requestUri);
        } catch (RequestException $guzzleException) {
            if (!$guzzleException->getResponse()) {
                throw $guzzleException;
            }
            return $guzzleException->getResponse();
        }
        $outboundHttpResponse = $this->getOutboundHttpResponseTransfer($apiResponse);

        return $this->outboundRequestMapper
            ->mapOutboundHttpResponseToOutboundResponseTransfer
            (
                $outboundHttpResponse,
            );
    }

    /**
     * @param string $method
     * @param string $requestUri
     *
     * @throws \GuzzleHttp\Exception\GuzzleException !
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected
    function executeRequest(
        string $method,
        string $requestUri
    ): ResponseInterface {
        $this->logRequest($method, $requestUri);
        $apiResponse = $this->client->request($method, $requestUri, $this->config->getOutboundRequestConnectTimeout());
        $this->logResponseCode($apiResponse);

        return $apiResponse;
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $apiResponse
     *
     * @return \Generated\Shared\Transfer\OutboundHttpResponseTransfer
     */
    protected
    function getOutboundHttpResponseTransfer(
        ResponseInterface $apiResponse
    ): OutboundHttpResponseTransfer {
        $outboundHttpResponseTransfer = new OutboundHttpResponseTransfer();
        $outboundHttpResponseTransfer->setSuccessful($apiResponse->getStatusCode() < 400)
            ->setStatusCode((string)$apiResponse->getStatusCode())
            ->setBody($apiResponse->getBody()->getContents());

        $decodedJson = json_decode(
            $outboundHttpResponseTransfer->getBody()
        );

        $outboundHttpResponseTransfer->setJsonObject($decodedJson);

        return $outboundHttpResponseTransfer;
    }

    /**
     * @param string $method
     * @param string $apiEndpoint
     *
     * @return void
     */
    protected
    function logRequest(
        string $method,
        string $apiEndpoint
    ): void {
        $requestLogLine = "Request: $method $apiEndpoint";
        $this->getZedLogger()->info($requestLogLine);
    }

    /**
     * @return LoggerInterface
     */
    protected
    function getZedLogger(): LoggerInterface
    {
        return $this->getLogger(new ZedLoggerConfigPlugin());
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     *
     * @return void
     */
    protected
    function logResponseCode(
        ResponseInterface $response
    ): void {
        $responseLogLine = "Response: {$response->getStatusCode()} {$response->getReasonPhrase()}";
        $this->getZedLogger()->info($responseLogLine);
    }
}
