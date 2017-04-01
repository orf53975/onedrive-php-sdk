<?php

namespace Test\Unit\Krizalys\Onedrive\Resource\Factory;

use Krizalys\Onedrive\Resource\Factory\DriveItemFactory;

class DriveItemFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateFromProperties()
    {
        $driveItemFactory = new DriveItemFactory();
        $driveItem = $driveItemFactory->createFromProperties((object) []);
        $this->assertInstanceOf('Krizalys\Onedrive\Resource\DriveItem', $driveItem);
    }
}
