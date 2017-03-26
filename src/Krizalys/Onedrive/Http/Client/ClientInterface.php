<?php

namespace Krizalys\Onedrive\Http\Client;

use Krizalys\Onedrive\Http\Resource\ResourceInterface;

interface ClientInterface
{
    /**
     * @param string $host
     *        The host.
     * @param string $path
     *        The path.
     * @param array $headers.
     *        The headers.
     *
     * @return ResponseInterface
     *         The response.
     */
    function get($host, $path, array $headers = array());

    /**
     * @param string $host
     *        The host.
     * @param string $path
     *        The path.
     * @param ResourceInterface $body
     *        The body.
     * @param array $headers.
     *        The headers.
     *
     * @return ResponseInterface
     *         The response.
     */
    function post($host, $path, ResourceInterface $body, array $headers = array());

    /**
     * @param string $host
     *        The host.
     * @param string $path
     *        The path.
     * @param ResourceInterface $body
     *        The body.
     * @param array $headers.
     *        The headers.
     *
     * @return ResponseInterface
     *         The response.
     */
    function put($host, $path, ResourceInterface $body, array $headers = array());

    /**
     * @param string $host
     *        The host.
     * @param string $path
     *        The path.
     * @param ResourceInterface $body
     *        The body.
     * @param array $headers.
     *        The headers.
     *
     * @return ResponseInterface
     *         The response.
     */
    function delete($host, $path, array $headers = array());

    /**
     * @param string $host
     *        The host.
     * @param string $path
     *        The path.
     * @param ResourceInterface $body
     *        The body.
     * @param array $headers.
     *        The headers.
     *
     * @return ResponseInterface
     *         The response.
     */
    function patch($host, $path, ResourceInterface $body, array $headers = array());

    /**
     * @param string $host
     *        The host.
     * @param string $method
     *        The method.
     * @param string $path
     *        The path.
     * @param ResourceInterface $body
     *        The body.
     * @param array $headers.
     *        The headers.
     *
     * @return ResponseInterface
     *         The response.
     */
    function request($host, $method, $path, ResourceInterface $body, array $headers = array());
}
