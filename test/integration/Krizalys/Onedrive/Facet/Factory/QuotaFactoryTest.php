<?php

namespace Test\Integration\Krizalys\Onedrive\Facet\Factory;

use Krizalys\Onedrive\Facet\Factory\QuotaFactory;
use Krizalys\Onedrive\Facet\Factory\StoragePlanSetFactory;
use Krizalys\Onedrive\Facet\Quota;

class QuotaFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateFromProperties()
    {
        $storagePlanSetFactory = new StoragePlanSetFactory();
        $quotaFactory          = new QuotaFactory($storagePlanSetFactory);

        $quota = $quotaFactory->createFromProperties((object) [
            'total'     => '1',
            'used'      => '2',
            'remaining' => '3',
            'deleted'   => '4',
            'state'     => Quota::STATE_NORMAL,

            'storagePlans' => (object) [
                'upgradeAvailable' => true,
            ],
        ]);

        $this->assertInstanceOf('Krizalys\Onedrive\Facet\Quota', $quota);
        $this->assertSame(1, $quota->getTotal());
        $this->assertSame(2, $quota->getUsed());
        $this->assertSame(3, $quota->getRemaining());
        $this->assertSame(4, $quota->getDeleted());
        $this->assertSame(Quota::STATE_NORMAL, $quota->getState());
        $storagePlans = $quota->getStoragePlans();
        $this->assertInstanceOf('Krizalys\Onedrive\Facet\StoragePlanSet', $storagePlans);
        $this->assertTrue($storagePlans->isUpgradeAvailable());
    }
}
