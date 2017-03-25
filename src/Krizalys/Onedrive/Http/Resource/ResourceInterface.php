<?php

namespace Krizalys\Onedrive\Http\Resource;

interface ResourceInterface
{
    /**
     * @return string
     *         The content type.
     */
    function getContentType();

    /**
     * @return resource
     *         The content, as a PHP stream.
     */
    function getContent();
}
