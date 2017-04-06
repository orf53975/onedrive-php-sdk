<?php

namespace Test\Integration\Krizalys\Onedrive\Facet\Factory;

use Krizalys\Onedrive\Facet\Factory\FileSystemInfoFactory;

class FileSystemInfoFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateFromProperties()
    {
        $fileSystemInfoFactory = new FileSystemInfoFactory();

        $fileSystemInfo = $fileSystemInfoFactory->createFromProperties((object) [
            'createdDateTime'      => '1970-01-01T00:00:01+00:00',
            'lastAccessedDateTime' => '1970-01-01T00:00:02+00:00',
            'lastModifiedDateTime' => '1970-01-01T00:00:03+00:00',
        ]);

        $this->assertInstanceOf('Krizalys\Onedrive\Facet\FileSystemInfo', $fileSystemInfo);
        $this->assertSame('1970-01-01T00:00:01+00:00', $fileSystemInfo->getCreatedDateTime()->format('c'));
        $this->assertSame('1970-01-01T00:00:02+00:00', $fileSystemInfo->getLastAccessedDateTime()->format('c'));
        $this->assertSame('1970-01-01T00:00:03+00:00', $fileSystemInfo->getLastModifiedDateTime()->format('c'));
    }
}
