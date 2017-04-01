<?php

namespace Krizalys\Onedrive\Http;

use Psr\Http\Message\UriInterface;

class Uri implements UriInterface
{
    /**
     * @var string
     *      The scheme.
     */
    private $scheme;

    /**
     * @var null|string
     *      The username.
     */
    private $username;

    /**
     * @var null|string
     *      The password.
     */
    private $password;

    /**
     * @var string
     *      The host.
     */
    private $host;

    /**
     * @var null|int
     *      The port.
     */
    private $port;

    /**
     * @var string
     *      The path.
     */
    private $path;

    /**
     * @var null|string
     *      The query.
     */
    private $query;

    /**
     * @var null|string
     *      The fragment.
     */
    private $fragment;

    /**
     */
    public function __construct()
    {
        $this->scheme   = '';
        $this->username = null;
        $this->password = null;
        $this->host     = '';
        $this->port     = null;
        $this->path     = '';
        $this->query    = null;
        $this->fragment = null;
    }

    /**
     * {@inheritdoc}
     */
    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthority()
    {
        $authority = $this->host;
        $port      = $this->port;
        $userInfo  = $this->getUserInfoOrNull();

        if ($userInfo !== null) {
            $authority = "$userInfo@$authority";
        }

        if ($port !== null) {
            $authority = "$authority:$port";
        }

        return $authority;
    }

    /**
     * {@inheritdoc}
     */
    public function getUserInfo()
    {
        $userInfo = $this->getUserInfoOrNull();

        // UriInterface requires the value to be a string.
        return $userInfo !== null ? $userInfo : '';
    }

    /**
     * {@inheritdoc}
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * {@inheritdoc}
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * {@inheritdoc}
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * {@inheritdoc}
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * {@inheritdoc}
     */
    public function getFragment()
    {
        return $this->fragment;
    }

    /**
     * {@inheritdoc}
     */
    public function withScheme($scheme)
    {
        $uri         = clone $this;
        $uri->scheme = (string) $scheme;
        return $uri;
    }

    /**
     * {@inheritdoc}
     */
    public function withUserInfo($user, $password = null)
    {
        $uri           = clone $this;
        $uri->username = (string) $user;
        $uri->password = $password !== null ? (string) $password : null;
        return $uri;
    }

    /**
     * {@inheritdoc}
     */
    public function withHost($host)
    {
        $uri       = clone $this;
        $uri->host = (string) $host;
        return $uri;
    }

    /**
     * {@inheritdoc}
     */
    public function withPort($port)
    {
        $uri       = clone $this;
        $uri->port = (int) $port;
        return $uri;
    }

    /**
     * {@inheritdoc}
     */
    public function withPath($path)
    {
        $uri       = clone $this;
        $uri->path = (string) $path;
        return $uri;
    }

    /**
     * {@inheritdoc}
     */
    public function withQuery($query)
    {
        $uri        = clone $this;
        $uri->query = (string) $query;
        return $uri;
    }

    /**
     * {@inheritdoc}
     */
    public function withFragment($fragment)
    {
        $uri           = clone $this;
        $uri->fragment = (string) $fragment;
        return $uri;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        $scheme = $this->scheme;
        $host   = $this->host;

        // Scheme and hosts are required.
        if ($scheme == '' || $host == '') {
            return '';
        }

        $string   = $this->getAuthority() . $this->path;
        $path     = $this->path;
        $query    = $this->query;
        $fragment = $this->fragment;

        if ($scheme != '') {
            $string = "$scheme://$string";
        }

        if ($query !== null) {
            $string = "$string?$query";
        }

        if ($fragment !== null) {
            $string = "$string#$fragment";
        }

        return $string;
    }

    /**
     * @return null|string
     *         The user info, or null.
     */
    private function getUserInfoOrNull()
    {
        $username = $this->username;
        $password = $this->password;
        return $password === null ? $username : "$username:$password";
    }
}
