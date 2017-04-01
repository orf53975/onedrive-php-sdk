<?php

namespace Test\Unit\Krizalys\Onedrive\Resource\Factory;

use Krizalys\Onedrive\Facet\Factory\QuotaFactory;
use Krizalys\Onedrive\Facet\Factory\StoragePlanSetFactory;
use Krizalys\Onedrive\Resource\Drive;
use Krizalys\Onedrive\Resource\Factory\DriveFactory;
use Krizalys\Onedrive\Resource\Factory\IdentityFactory;
use Krizalys\Onedrive\Resource\Factory\IdentitySetFactory;
use Krizalys\Onedrive\Resource\Factory\ThumbnailFactory;
use Krizalys\Onedrive\Resource\Factory\ThumbnailSetFactory;

class DriveFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $thumbnailFactory      = new ThumbnailFactory();
        $thumbnailSetFactory   = new ThumbnailSetFactory($thumbnailFactory);
        $identityFactory       = new IdentityFactory($thumbnailSetFactory);
        $identitySetFactory    = new IdentitySetFactory($identityFactory);
        $storagePlanSetFactory = new StoragePlanSetFactory();
        $quotaFactory          = new QuotaFactory($storagePlanSetFactory);
        $sut                   = new DriveFactory($identitySetFactory, $quotaFactory);

        $drive = $sut->create((object) [
            'id'        => '1234',
            'driveType' => 'personal',
            'owner'     => (object) [],
            'quota'     => (object) [],
            'status'    => (object) [],
        ]);

        $this->assertInstanceOf('Krizalys\Onedrive\Resource\Drive', $drive);
        $this->assertSame('1234', $drive->getId());
        $this->assertSame(Drive::TYPE_PERSONAL, $drive->getDriveType());
        $owner = $drive->getOwner();
        $this->assertInstanceOf('Krizalys\Onedrive\Resource\IdentitySet', $owner);
        $quota = $drive->getQuota();
        $this->assertInstanceOf('Krizalys\Onedrive\Facet\Quota', $quota);
        $status = $drive->getStatus();
        $this->assertEquals((object) [], $status);
    }
}
