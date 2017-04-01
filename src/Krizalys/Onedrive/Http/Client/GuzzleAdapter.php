<?php

namespace Krizalys\Onedrive\Http\Client;

use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use Krizalys\Onedrive\Http\Connection;
use Krizalys\Onedrive\Http\UriCanonicalizer;
use Psr\Http\Message\StreamInterface;

class GuzzleAdapter implements AdapterInterface
{
    /**
     * @var GuzzleClientInterface
     *      The Guzzle client.
     */
    private $guzzleClient;

    /**
     * @param GuzzleClientInterface $guzzleClient
     *        The Guzzle client.
     */
    public function __construct(GuzzleClientInterface $guzzleClient)
    {
        $this->guzzleClient = $guzzleClient;
    }

    /**
     * {@inheritdoc}
     */
    public function get(Connection $connection, $path, array $headers = [])
    {
        $canonicalizer = new UriCanonicalizer();
        $uri           = $canonicalizer->canonicalize($connection, $path);
        return $this->guzzleClient->get($uri, ['headers' => $headers]);
    }

    /**
     * {@inheritdoc}
     */
    public function post(Connection $connection, $path, StreamInterface $body, array $headers = [])
    {
        $canonicalizer = new UriCanonicalizer();
        $uri           = $canonicalizer->canonicalize($connection, $path);

        return $this->guzzleClient->post($uri, [
            'headers' => $headers,
            'body'    => $body,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function put(Connection $connection, $path, StreamInterface $body, array $headers = [])
    {
        $canonicalizer = new UriCanonicalizer();
        $uri           = $canonicalizer->canonicalize($connection, $path);

        return $this->guzzleClient->put($uri, [
            'headers' => $headers,
            'body'    => $body,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function delete(Connection $connection, $path, array $headers = [])
    {
        $canonicalizer = new UriCanonicalizer();
        $uri           = $canonicalizer->canonicalize($connection, $path);
        return $this->guzzleClient->delete($uri, ['headers' => $headers]);
    }

    /**
     * {@inheritdoc}
     */
    public function patch(Connection $connection, $path, StreamInterface $body, array $headers = [])
    {
        $canonicalizer = new UriCanonicalizer();
        $uri           = $canonicalizer->canonicalize($connection, $path);

        return $this->guzzleClient->patch($uri, [
            'headers' => $headers,
            'body'    => $body,
        ]);
    }
}
