<?php

namespace Test\Integration\Krizalys\Onedrive\Facet\Factory;

use Krizalys\Onedrive\Facet\Factory\VideoFactory;

class VideoFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateFromProperties()
    {
        $videoFactory = new VideoFactory();

        $video = $videoFactory->createFromProperties((object) [
            'bitrate'  => '1',
            'duration' => '2',
            'height'   => '3',
            'width'    => '4',
        ]);

        $this->assertInstanceOf('Krizalys\Onedrive\Facet\Video', $video);
        $this->assertSame(1, $video->getBitrate());
        $this->assertSame(2, $video->getDuration());
        $this->assertSame(3, $video->getHeight());
        $this->assertSame(4, $video->getWidth());
    }
}
