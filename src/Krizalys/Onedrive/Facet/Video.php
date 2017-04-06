<?php

namespace Krizalys\Onedrive\Facet;

class Video
{
    /**
     * @var int
     *      The bitrate, in bits per second.
     */
    private $bitrate;

    /**
     * @var int
     *      The duration, in milliseconds.
     */
    private $duration;

    /**
     * @var int
     *      The height, in pixels.
     */
    private $height;

    /**
     * @var int
     *      The width, in pixels.
     */
    private $width;

    /**
     * @param int $bitrate
     *        The bitrate, in bits per second.
     * @param int $duration
     *        The duration, in milliseconds.
     * @param int $height
     *        The height, in pixels.
     * @param int $width
     *        The width, in pixels.
     */
    public function __construct(
        $bitrate = 0,
        $duration = 0,
        $height = 0,
        $width = 0
    ) {
        $this->setBitrate($bitrate);
        $this->setDuration($duration);
        $this->setHeight($height);
        $this->setWidth($width);
    }

    /**
     * @param int $bitrate
     *        The bitrate, in bits per second.
     */
    public function setBitrate($bitrate)
    {
        $this->bitrate = (int) $bitrate;
    }

    /**
     * @return int
     *         The bitrate, in bits per second.
     */
    public function getBitrate()
    {
        return $this->bitrate;
    }

    /**
     * @param int $duration
     *        The duration, in milliseconds.
     */
    public function setDuration($duration)
    {
        $this->duration = (int) $duration;
    }

    /**
     * @return int
     *         The duration, in milliseconds.
     */
    public function getDuration()
    {
        return $this->duration;
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
}
