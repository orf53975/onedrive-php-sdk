<?php

namespace Krizalys\Onedrive\Http;

class Connection
{
    /**
     * @var string
     *      The host.
     */
    private $host;

    /**
     * @var int
     *      The port.
     */
    private $port;

    /**
     * @var bool
     *      The secure toggle.
     */
    private $secure;

    /**
     * @param string $host
     *        The host.
     * @param int $port
     *        The port.
     * @param bool $secure
     *        The secure toggle.
     */
    public function __construct($host, $port = 80, $secure = false)
    {
        $this->host   = (string) $host;
        $this->port   = (int) $port;
        $this->secure = (bool) $secure;
    }

    /**
     * @return string
     *         The host.
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return int
     *         The port.
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @return bool
     *         The secure toggle.
     */
    public function isSecure()
    {
        return $this->secure;
    }
}
