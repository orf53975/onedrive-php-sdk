<?php

namespace Krizalys\Onedrive\Http\Resource;

/** @todo Rename into Memory resource? */
class Resource implements ResourceInterface
{
    /** @todo Extract into a trait or abstract class. */
    private $contentType;

    private $content;

    public function __construct($content = '', $contentType = 'text/html')
    {
        $this->contentType = (string) $contentType;
        $this->content     = (string) $content;
    }

    public function getContentType()
    {
        return $this->contentType;
    }

    public function getContent()
    {
        /** @todo Move to stream factory. */
        $stream = fopen('php://memory', 'rw+b');
        fwrite($stream, $this->content);
        rewind($stream);

        return $stream;
    }
}
