<?php

namespace Krizalys\Onedrive\Http\Response;

use Krizalys\Onedrive\Http\Resource\ResourceInterface;

class ResponseBuilder
{
    private $statusCode;
    private $statusReason;
    private $headers;
    private $body;

    public function __construct()
    {
        $this->reset();
    }

    public function reset()
    {
        $this->statusCode = 200;
        $this->statusCode = 'OK';
        $this->headers    = array();
        $this->body       = null;
        return $this;
    }

    public function setStatusCode($statusCode)
    {
        $this->statusCode = (int) $statusCode;
        return $this;
    }

    public function setStatusReason($statusReason)
    {
        $this->statusReason = (string) $statusReason;
        return $this;
    }

    public function setStatus($statusCode, $statusReason)
    {
        $this->statusCode   = (int) $statusCode;
        $this->statusReason = (string) $statusReason;
        return $this;
    }

    public function addHeader($header)
    {
        $this->headers[] = $header;
        return $this;
    }

    public function setBody(ResourceInterface $body)
    {
        $this->body = $body;
        return $this;
    }

    public function build()
    {
        return new Response(
            $this->statusCode,
            $this->statusReason,
            $this->headers,
            $this->body
        );
    }
}
