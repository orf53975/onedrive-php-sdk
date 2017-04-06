<?php

namespace Test\Integration\Krizalys\Onedrive\Facet\Factory;

use Krizalys\Onedrive\Facet\Factory\LocationFactory;

class LocationFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateFromProperties()
    {
        $locationFactory = new LocationFactory();

        $location = $locationFactory->createFromProperties((object) [
            'altitude'  => '1.1',
            'latitude'  => '2.2',
            'longitude' => '3.3',
        ]);

        $this->assertInstanceOf('Krizalys\Onedrive\Facet\Location', $location);
        $this->assertSame(1.1, $location->getAltitude());
        $this->assertSame(2.2, $location->getLatitude());
        $this->assertSame(3.3, $location->getLongitude());
    }
}
