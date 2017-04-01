<?php

namespace Krizalys\Onedrive\Resource;

class Thumbnail
{
    /**
     * @var int
     *      The width, in pixels.
     */
    private $width;

    /**
     * @var int
     *      The height, in pixels.
     */
    private $height;

    /**
     * @var null|UriInterface
     *      The URL.
     */
    private $url;

    /**
     * @param int $width
     *        The width, in pixels.
     * @param int $height
     *        The height, in pixels.
     * @param null|UriInterface $url
     *        The URL.
     */
    public function __construct(
        $width = 0,
        $height = 0,
        UriInterface $url = null
    ) {
        $this->setWidth($width);
        $this->setHeight($height);
        $this->setUrl($url);
    }

    /**
     * @param int $width
     *        The width, in pixels.
     */
    public function setWidth($width)
    {
        $this->width = (int) $width;
    }

    /**
     * @return int
     *         The width, in pixels.
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param int $height
     *        The height, in pixels.
     */
    public function setHeight($height)
    {
        $this->height = (int) $height;
    }

    /**
     * @return int
     *         The height, in pixels.
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param null|UriInterface $url
     *        The URL.
     */
    public function setUrl(UriInterface $url = null)
    {
        $this->url = $url;
    }

    /**
     * @return null|UriInterface $url
     *         The URL.
     */
    public function getUrl()
    {
        return $this->url;
    }
}
