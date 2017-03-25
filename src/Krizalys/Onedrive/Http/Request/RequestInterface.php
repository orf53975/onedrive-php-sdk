<?php

namespace Krizalys\Onedrive\Http\Request;

interface RequestInterface
{
    /**
     * @return string
     *         The method.
     */
    function getMethod();

    /**
     * @return string
     *         The path.
     */
    function getPath();

    /**
     * @return array
     *         The headers.
     */
    function getHeaders();

    /**
     * @return null|ResourceInterface
     *         The body.
     */
    function getBody();
}
