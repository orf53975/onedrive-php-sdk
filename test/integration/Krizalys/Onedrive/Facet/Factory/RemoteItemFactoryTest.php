<?php

namespace Test\Integration\Krizalys\Onedrive\Facet\Factory;

use Krizalys\Onedrive\Facet\Factory\FileFactory;
use Krizalys\Onedrive\Facet\Factory\FileSystemInfoFactory;
use Krizalys\Onedrive\Facet\Factory\FolderFactory;
use Krizalys\Onedrive\Facet\Factory\RemoteItemFactory;
use Krizalys\Onedrive\Facet\Factory\SharedFactory;
use Krizalys\Onedrive\Resource\Factory\IdentitySetFactory;
use Krizalys\Onedrive\Resource\Factory\ItemReferenceFactory;

class RemoteItemFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateFromProperties()
    {
        $identitySetFactory    = new IdentitySetFactory();
        $fileFactory           = new FileFactory();
        $fileSystemInfoFactory = new FileSystemInfoFactory();
        $folderFactory         = new FolderFactory();
        $itemReferenceFactory  = new ItemReferenceFactory();
        $sharedFactory         = new SharedFactory();

        $remoteItemFactory = new RemoteItemFactory(
            $identitySetFactory,
            $fileFactory,
            $fileSystemInfoFactory,
            $folderFactory,
            $itemReferenceFactory,
            $sharedFactory
        );

        $remoteItem = $remoteItemFactory->createFromProperties((object) [
            'createdBy'            => (object) [],
            'file'                 => (object) [],
            'fileSystemInfo'       => (object) [],
            'folder'               => (object) [],
            'id'                   => '1',
            'lastModifiedBy'       => (object) [],
            'lastModifiedDateTime' => '1970-01-01T00:00:01+00:00',
            'name'                 => 'Name',
            'parentReference'      => (object) [],
            'shared'               => (object) [],
            'size'                 => '2',
            'webUrl'               => 'http://te.st',
        ]);

        $this->assertInstanceOf('Krizalys\Onedrive\Facet\RemoteItem', $remoteItem);
        $this->assertSame(1, $remoteItem->getId());
        $this->assertSame('1970-01-01T00:00:01+00:00', $remoteItem->getLastModifiedDateTime()->format('c'));
        $this->assertSame('Name', $remoteItem->getName());
    }
}
