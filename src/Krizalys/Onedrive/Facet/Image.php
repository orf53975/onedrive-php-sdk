<?php

namespace Krizalys\Onedrive\Facet;

class Image
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
     * @param int $width
     *        The width, in pixels.
     * @param int $height
     *        The height, in pixels.
     */
    public function __construct($width = 0, $height = 0)
    {
        $this->setWidth($width);
        $this->setHeight($height);
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
}
