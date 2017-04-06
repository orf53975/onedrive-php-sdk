<?php

namespace Test\Integration\Krizalys\Onedrive\Facet\Factory;

use Krizalys\Onedrive\Facet\Factory\ImageFactory;

class ImageFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateFromProperties()
    {
        $imageFactory = new ImageFactory();

        $image = $imageFactory->createFromProperties((object) [
            'width'  => '1',
            'height' => '2',
        ]);

        $this->assertInstanceOf('Krizalys\Onedrive\Facet\Image', $image);
        $this->assertSame(1, $image->getWidth());
        $this->assertSame(2, $image->getHeight());
    }
}
