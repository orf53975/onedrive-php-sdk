<?php

namespace Test\Integration\Krizalys\Onedrive\Resource\Factory;

use Krizalys\Onedrive\Resource\Factory\ThumbnailFactory;
use Krizalys\Onedrive\Resource\Factory\ThumbnailSetFactory;

class ThumbnailSetFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateFromProperties()
    {
        $thumbnailFactory    = new ThumbnailFactory();
        $thumbnailSetFactory = new ThumbnailSetFactory($thumbnailFactory);

        $thumbnailSet = $thumbnailSetFactory->createFromProperties((object) [
            'id'     => '1',
            'small'  => (object) [],
            'medium' => (object) [],
            'large'  => (object) [],
            'source' => (object) [],
        ]);

        $this->assertInstanceOf('Krizalys\Onedrive\Resource\ThumbnailSet', $thumbnailSet);
        $this->assertSame('1', $thumbnailSet->getId());
        $small = $thumbnailSet->getSmall();
        $this->assertInstanceOf('Krizalys\Onedrive\Resource\Thumbnail', $small);
        $medium = $thumbnailSet->getMedium();
        $this->assertInstanceOf('Krizalys\Onedrive\Resource\Thumbnail', $medium);
        $large = $thumbnailSet->getLarge();
        $this->assertInstanceOf('Krizalys\Onedrive\Resource\Thumbnail', $large);
        $source = $thumbnailSet->getSource();
        $this->assertInstanceOf('Krizalys\Onedrive\Resource\Thumbnail', $source);
    }
}
