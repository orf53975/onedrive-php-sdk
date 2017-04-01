<?php

namespace Test\Integration\Krizalys\Onedrive\Resource\Factory;

use Krizalys\Onedrive\Resource\Factory\IdentityFactory;
use Krizalys\Onedrive\Resource\Factory\ThumbnailFactory;
use Krizalys\Onedrive\Resource\Factory\ThumbnailSetFactory;

class IdentityFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateFromProperties()
    {
        $thumbnailFactory    = new ThumbnailFactory();
        $thumbnailSetFactory = new ThumbnailSetFactory($thumbnailFactory);
        $identityFactory     = new IdentityFactory($thumbnailSetFactory);

        $identity = $identityFactory->createFromProperties((object) [
            'id'          => '1',
            'displayName' => 'Jane Doe',
            'thumbnails'  => (object) [],
        ]);

        $this->assertInstanceOf('Krizalys\Onedrive\Resource\Identity', $identity);
        $this->assertSame('1', $identity->getId());
        $this->assertSame('Jane Doe', $identity->getDisplayName());
        $thumbnails = $identity->getThumbnails();
        $this->assertInstanceOf('Krizalys\Onedrive\Resource\ThumbnailSet', $thumbnails);
    }
}
