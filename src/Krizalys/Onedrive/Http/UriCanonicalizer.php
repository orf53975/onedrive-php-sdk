<?php

namespace Krizalys\Onedrive\Http;

class UriCanonicalizer
{
    /**
     * @param Connection $connection
     *        The connection.
     * @param string $path
     *        The path.
     * @param null|string $query
     *        The query string.
     * @param null|string $fragment
     *        The fragment.
     *
     * @return \Krizalys\Onedrive\Http\UriInterface
     *         The URI.
     */
    public function canonicalize(
        Connection $connection,
        $path = '',
        $query = null,
        $fragment = null
    ) {
        $uri      = new Uri();
        $host     = $connection->getHost();
        $port     = $connection->getPort();
        $isSecure = $connection->isSecure();

        if ($isSecure) {
            $scheme      = 'https';
            $defaultPort = 443;
        } else {
            $scheme      = 'http';
            $defaultPort = 80;
        }

        if ($port != $defaultPort) {
            $uri = $uri->withPort($port);
        }

        return $uri
            ->withScheme($scheme)
            ->withHost($host)
            ->withPath($path)
            ->withQuery($query)
            ->withFragment($fragment);
    }
}
