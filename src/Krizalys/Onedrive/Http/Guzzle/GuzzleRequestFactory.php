<?php

namespace Krizalys\Onedrive\Http\Guzzle;

use GuzzleHttp\Request as GuzzleRequest;
use Krizalys\Onedrive\Http\Request\RequestInterface;

class GuzzleRequestFactory
{
    /**
     * @param string $host
     *        The host.
     * @param RequestInterface $request
     *        The request.
     *
     * @return \GuzzleHttp\RequestInterface
     *         The Guzzle request.
     */
    public function create($host, RequestInterface $request)
    {
        $url = 'http://' . $host . $request->getPath();

        return new GuzzleRequest($request->getMethod(), $url);
    }
}
