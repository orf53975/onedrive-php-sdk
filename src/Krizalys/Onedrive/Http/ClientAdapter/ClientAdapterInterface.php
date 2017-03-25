<?php

namespace Krizalys\Onedrive\Http\ClientAdapter;

use Krizalys\Onedrive\Http\Request\RequestInterface;
use Krizalys\Onedrive\Http\Resource\ResourceInterface;

interface ClientAdapterInterface
{
    /**
     * @param string $host
     *        The host.
     * @param RequestInterface $request
     *        The request.
     *
     * @return ResponseInterface
     *         The response.
     */
    function send($host, RequestInterface $request);
}
