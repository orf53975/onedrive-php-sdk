<?php

namespace Krizalys\Onedrive\Http\Resource;

class ResourceFactory
{
    public function create($content = '', $contentType = 'text/html')
    {
        return new Resource($content, $contentType);
    }
}
