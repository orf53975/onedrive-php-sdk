<?php

namespace Test\Integration\Krizalys\Onedrive\Facet\Factory;

use Krizalys\Onedrive\Facet\Factory\FileFactory;
use Krizalys\Onedrive\Facet\Factory\HashesFactory;

class FileFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateFromProperties()
    {
        $hashesFactory = new HashesFactory();
        $fileFactory   = new FileFactory($hashesFactory);

        $file = $fileFactory->createFromProperties((object) [
            'mimeType'           => 'application/x-mime-type',
            'hashes'             => (object) [],
            'processingMetadata' => true,
        ]);

        $this->assertInstanceOf('Krizalys\Onedrive\Facet\File', $file);
        $this->assertSame('application/x-mime-type', $file->getMimeType());
        $this->assertTrue($file->isProcessingMetadata());
        $hashes = $file->getHashes();
        $this->assertInstanceOf('Krizalys\Onedrive\Facet\Hashes', $hashes);
    }
}
