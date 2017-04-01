<?php

namespace Krizalys\Onedrive\Http\Client;

use Krizalys\Onedrive\Http\Connection;
use Psr\Http\Message\StreamInterface;

interface AdapterInterface
{
    /**
     * Sends a GET request from this client.
     *
     * @param Connection $connection
     *        The connection.
     * @param string $host
     *        The host.
     * @param string $path
     *        The path.
     * @param array $headers.
     *        The headers.
     *
     * @return \Psr\Http\Message\ResponseInterface
     *         The response.
     */
    public function get(Connection $connection, $path, array $headers = []);

    /**
     * Sends a POST request from this client.
     *
     * @param Connection $connection
     *        The connection.
     * @param string $host
     *        The host.
     * @param string $path
     *        The path.
     * @param StreamInterface $body
     *        The body.
     * @param array $headers.
     *        The headers.
     *
     * @return \Psr\Http\Message\ResponseInterface
     *         The response.
     */
    public function post(Connection $connection, $path, StreamInterface $body, array $headers = []);

    /**
     * Sends a PUT request from this client.
     *
     * @param Connection $connection
     *        The connection.
     * @param string $host
     *        The host.
     * @param string $path
     *        The path.
     * @param StreamInterface $body
     *        The body.
     * @param array $headers.
     *        The headers.
     *
     * @return \Psr\Http\Message\ResponseInterface
     *         The response.
     */
    public function put(Connection $connection, $path, StreamInterface $body, array $headers = []);

    /**
     * Sends a DELETE request from this client.
     *
     * @param Connection $connection
     *        The connection.
     * @param string $host
     *        The host.
     * @param string $path
     *        The path.
     * @param array $headers.
     *        The headers.
     *
     * @return \Psr\Http\Message\ResponseInterface
     *         The response.
     */
    public function delete(Connection $connection, $path, array $headers = []);

    /**
     * Sends a PATCH request from this client.
     *
     * @param Connection $connection
     *        The connection.
     * @param string $host
     *        The host.
     * @param string $path
     *        The path.
     * @param StreamInterface $body
     *        The body.
     * @param array $headers.
     *        The headers.
     *
     * @return \Psr\Http\Message\ResponseInterface
     *         The response.
     */
    public function patch(Connection $connection, $path, StreamInterface $body, array $headers = []);
}
