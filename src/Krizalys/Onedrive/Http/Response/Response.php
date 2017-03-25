<?php

namespace Krizalys\Onedrive\Http\Response;

use Krizalys\Onedrive\Http\Resource\ResourceInterface;

class Response implements ResponseInterface
{
    private $statusCode;
    private $statusReason;
    private $headers;
    private $body;

    /**
     * @param int               $statusCode
     *        The status code.
     * @param string            $statusReason
     *        The status reason.
     * @param array             $headers
     *        The headers.
     * @param ResourceInterface $body
     *        The body.
     */
    public function __construct(
        $statusCode = 200,
        $statusReason = 'OK',
        array $headers = array(),
        ResourceInterface $body = null
    ) {
        $this->statusCode   = (int) $statusCode;
        $this->statusReason = (string) $statusReason;
        $this->headers      = $headers;
        $this->body         = $body;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function getStatusReason()
    {
        return $this->statusReason;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getBody()
    {
        return $this->body;
    }
}
