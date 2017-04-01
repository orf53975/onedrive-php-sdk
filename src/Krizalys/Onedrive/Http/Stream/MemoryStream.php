<?php

namespace Krizalys\Onedrive\Http\Stream;

use Psr\Http\Message\StreamInterface;

class MemoryStream implements StreamInterface
{
    /**
     * @var string
     *      The buffer.
     */
    private $buffer;

    /**
     * @param string $buffer
     *        The buffer.
     */
    public function __construct($buffer = '')
    {
        $this->buffer = (string) $buffer;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function detach()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getSize()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function tell()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function eof()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function isSeekable()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function seek($offset, $whence = SEEK_SET)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function isWritable()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function write($string)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function isReadable()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function read($length)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getContents()
    {
    }

    /**
     * {@inheritdoc}
     */
    public function getMetadata($key = null)
    {
    }
}
