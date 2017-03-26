<?php

namespace Krizalys\Onedrive\Http\Resource;

class StreamResource implements ResourceInterface
{
    /** @todo Extract into a trait or abstract class. */
    private $contentType;

    /**
     * @var resource
     *      The PHP stream.
     */
    private $stream;

    public function __construct($stream, $contentType = 'text/html')
    {
        $this->contentType = (string) $contentType;
        $this->stream      = $stream;
    }

    public function getContentType()
    {
        return $this->contentType;
    }

    public function getContent()
    {
        return $this->stream;
    }
}
