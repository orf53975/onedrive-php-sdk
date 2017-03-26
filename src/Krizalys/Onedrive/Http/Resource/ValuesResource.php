<?php

namespace Krizalys\Onedrive\Http\Resource;

class ValuesResource implements ResourceInterface
{
    private $values;

    public function __construct(array $values = array())
    {
        $this->values = $values;
    }

    public function getContentType()
    {
        return 'application/x-www-form-urlencoded';
    }

    public function getContent()
    {
        /** @todo Use http_build_query() */
        $keys   = array_keys($this->values);
        $values = array_map(array($this, 'formatField'), $this->values, $keys);
        $values = implode('&', $values); /** Make the separator configurable (some servers use ';'). */

        /** @todo Move to stream factory. */
        $stream = fopen('php://memory', 'rw+b');
        fwrite($stream, $values);
        rewind($stream);

        return $stream;
    }

    private function formatField($key, $value)
    {
        $key   = urlencode($key);
        $value = urlencode($value);

        return sprintf('%s=%s', $key, $value);
    }
}
