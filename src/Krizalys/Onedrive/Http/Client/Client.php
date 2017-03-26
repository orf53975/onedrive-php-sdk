<?php

namespace Krizalys\Onedrive\Http\Client;

use Krizalys\Onedrive\Http\ClientAdapter\ClientAdapterInterface;
use Krizalys\Onedrive\Http\Request\Request;
use Krizalys\Onedrive\Http\Resource\ResourceInterface;

class Client implements ClientInterface
{
    /**
     * @var ClientAdapterInterface $adapter
     *      The client adapter.
     */
    private $adapter;

    /**
     * @param ClientAdapterInterface $adapter
     *        The client adapter.
     */
    public function __construct(ClientAdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * {@inheritdoc}
     */
    public function get($host, $path, array $headers = array())
    {
        $request = new Request('GET', $path, $headers);

        return $this->adapter->send($host, $request);
    }

    /**
     * {@inheritdoc}
     */
    public function post($host, $path, ResourceInterface $body, array $headers = array())
    {
        $request = new Request('POST', $path, $headers, $body);

        return $this->adapter->send($host, $request);
    }

    /**
     * {@inheritdoc}
     */
    public function put($host, $path, ResourceInterface $body, array $headers = array())
    {
        $request = new Request('PUT', $path, $headers, $body);

        return $this->adapter->send($host, $request);
    }

    /**
     * {@inheritdoc}
     */
    public function delete($host, $path, array $headers = array())
    {
        $request = new Request('DELETE', $path, $headers);

        return $this->adapter->send($host, $request);
    }

    /**
     * {@inheritdoc}
     */
    public function patch($host, $path, ResourceInterface $body, array $headers = array())
    {
        $request = new Request('PATCH', $path, $headers, $body);

        return $this->adapter->send($host, $request);
    }

    /**
     * {@inheritdoc}
     */
    public function request($host, $method, $path, ResourceInterface $body, array $headers = array())
    {
        $request = new Request($method, $path, $headers, $body);

        return $this->adapter->send($host, $request);
    }
}
