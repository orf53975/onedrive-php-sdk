<?php

namespace Test\Integration\Krizalys\Onedrive\Resource\Factory;

use Krizalys\Onedrive\Resource\Factory\ThumbnailFactory;

class ThumbnailFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateFromProperties()
    {
        $thumbnailFactory = new ThumbnailFactory();

        $thumbnail = $thumbnailFactory->createFromProperties((object) [
            'width'  => '1',
            'height' => '2',
            //'url'    => 'http://te.st/thumbnail.jpg',
        ]);

        $this->assertInstanceOf('Krizalys\Onedrive\Resource\Thumbnail', $thumbnail);
        $this->assertSame(1, $thumbnail->getWidth());
        $this->assertSame(2, $thumbnail->getHeight());
        //$this->assertInstanceOf('Krizalys\Onedrive\Http\UriInterface', $thumbnail->getUrl());
    }
}
