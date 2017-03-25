<?php

namespace Krizalys\Onedrive\Http\Request;

use Krizalys\Onedrive\Http\Resource\ResourceInterface;

class Request implements RequestInterface
{
    private $method;
    private $path;
    private $headers;
    private $body;

    public function __construct(
        $method = 'GET',
        $path = '/',
        array $headers = array(),
        ResourceInterface $body = null
    ) {
        $this->method  = (string) $method;
        $this->path    = (string) $path;
        $this->headers = $headers;
        $this->body    = $body;
    }

    /**
     * @return string
     *         The method.
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @return string
     *         The path.
     */
    public function getPath()
    {
        return $this->path;
    }


    /**
     * @return array
     *         The headers.
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @return null|ResourceInterface
     *         The body.
     */
    public function getBody()
    {
        return $this->body;
    }
}
