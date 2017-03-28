<?php

namespace Krizalys\Onedrive\Http\ClientAdapter;

use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use GuzzleHttp\ResponseInterface as GuzzleResponseInterface;
use GuzzleHttp\Request as GuzzleRequest;
use Krizalys\Onedrive\Http\Guzzle\GuzzleRequestFactory;
use Krizalys\Onedrive\Http\Request\RequestInterface;

class GuzzleResponseFactory
{
    public function create(GuzzleResponseInterface $response)
    {
        return new Response();
    }
}

/**
 * @class GuzzleClientAdapter
 */
class GuzzleClientAdapter implements ClientAdapterInterface
{
    /**
     * @var GuzzleClientInterface
     *      The Guzzle client.
     */
    private $client;

    /**
     * @var GuzzleRequestFactory
     *      The guzzle request factory.
     */
    private $requestFactory;

    /**
     * @param GuzzleClientInterface $client
     *        The Guzzle client.
     * @param GuzzleRequestFactory $requestFactory
     *        The guzzle request factory.
     */
    public function __construct(
        GuzzleClientInterface $client,
        GuzzleRequestFactory $requestFactory
    ) {
        $this->client         = $client;
        $this->requestFactory = $requestFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function send($host, RequestInterface $request)
    {
        $request  = $this->requestFactory->create($host, $request);
        $response = $this->client->send($request);

        return $this->responseFactory($response);
    }
}
