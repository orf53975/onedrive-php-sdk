<?php

namespace Test\Integration\Krizalys\Onedrive\Facet\Factory;

use Krizalys\Onedrive\Facet\Factory\PhotoFactory;

class PhotoFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateFromProperties()
    {
        $photoFactory = new PhotoFactory();

        $photo = $photoFactory->createFromProperties((object) [
            'takenDateTime'       => '1970-01-01T00:00:01+00:00',
            'cameraMake'          => 'Make Inc.',
            'cameraModel'         => 'Model',
            'fNumber'             => '1.1',
            'exposureDenominator' => '2.2',
            'exposureNumerator'   => '3.3',
            'focalLength'         => '4.4',
            'iso'                 => '5',
        ]);

        $this->assertInstanceOf('Krizalys\Onedrive\Facet\Photo', $photo);
        $this->assertSame('1970-01-01T00:00:01+00:00', $photo->getTakenDateTime()->format('c'));
        $this->assertSame('Make Inc.', $photo->getCameraMake());
        $this->assertSame('Model', $photo->getCameraModel());
        $this->assertSame(1.1, $photo->getFNumber());
        $this->assertSame(2.2, $photo->getExposureDenominator());
        $this->assertSame(3.3, $photo->getExposureNumerator());
        $this->assertSame(4.4, $photo->getFocalLength());
        $this->assertSame(5, $photo->getIso());
    }
}
