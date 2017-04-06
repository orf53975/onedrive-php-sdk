<?php

namespace Test\Integration\Krizalys\Onedrive\Facet\Factory;

use Krizalys\Onedrive\Facet\Factory\HashesFactory;

class HashesFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateFromProperties()
    {
        $hashesFactory = new HashesFactory();

        $hashes = $hashesFactory->createFromProperties((object) [
            'crc32Hash'    => '1',
            'sha1Hash'     => '2',
            'quickXorHash' => '3',
        ]);

        $this->assertInstanceOf('Krizalys\Onedrive\Facet\Hashes', $hashes);
        $this->assertSame('1', $hashes->getCrc32Hash());
        $this->assertSame('2', $hashes->getSha1Hash());
        $this->assertSame('3', $hashes->getQuickXorHash());
    }
}
