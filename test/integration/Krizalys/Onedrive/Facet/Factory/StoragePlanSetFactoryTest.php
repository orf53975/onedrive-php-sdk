<?php

namespace Test\Integration\Krizalys\Onedrive\Facet\Factory;

use Krizalys\Onedrive\Facet\Factory\StoragePlanSetFactory;

class StoragePlanSetFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateFromProperties()
    {
        $storagePlanSetFactory = new StoragePlanSetFactory();

        $storagePlanSet = $storagePlanSetFactory->createFromProperties((object) [
            'upgradeAvailable' => true,
        ]);

        $this->assertInstanceOf('Krizalys\Onedrive\Facet\StoragePlanSet', $storagePlanSet);
        $this->assertTrue($storagePlanSet->isUpgradeAvailable());
    }
}
