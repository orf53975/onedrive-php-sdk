<?php

namespace Test\Integration\Krizalys\Onedrive\Resource\Factory;

use Krizalys\Onedrive\Resource\Factory\IdentityFactory;
use Krizalys\Onedrive\Resource\Factory\IdentitySetFactory;
use Krizalys\Onedrive\Resource\Factory\ThumbnailFactory;
use Krizalys\Onedrive\Resource\Factory\ThumbnailSetFactory;

class IdentitySetFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateFromProperties()
    {
        $thumbnailFactory    = new ThumbnailFactory();
        $thumbnailSetFactory = new ThumbnailSetFactory($thumbnailFactory);
        $identityFactory     = new IdentityFactory($thumbnailSetFactory);
        $identitySetFactory  = new IdentitySetFactory($identityFactory);

        $identitySet = $identitySetFactory->createFromProperties((object) [
            'user'         => (object) [],
            'application'  => (object) [],
            'device'       => (object) [],
            'organization' => (object) [],
        ]);

        $this->assertInstanceOf('Krizalys\Onedrive\Resource\IdentitySet', $identitySet);
        $user = $identitySet->getUser();
        $this->assertInstanceOf('Krizalys\Onedrive\Resource\Identity', $user);
        $application = $identitySet->getApplication();
        $this->assertInstanceOf('Krizalys\Onedrive\Resource\Identity', $application);
        $device = $identitySet->getDevice();
        $this->assertInstanceOf('Krizalys\Onedrive\Resource\Identity', $device);
        $organization = $identitySet->getOrganization();
        $this->assertInstanceOf('Krizalys\Onedrive\Resource\Identity', $organization);
    }
}
