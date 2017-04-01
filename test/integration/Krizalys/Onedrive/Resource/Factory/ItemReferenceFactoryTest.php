<?php

namespace Test\Integration\Krizalys\Onedrive\Resource\Factory;

use Krizalys\Onedrive\Resource\Factory\ItemReferenceFactory;

class ItemReferenceFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateFromProperties()
    {
        $itemReferenceFactory = new ItemReferenceFactory();

        $itemReference = $itemReferenceFactory->createFromProperties((object) [
            'driveId' => '1',
            'id'      => '2',
            'path'    => '/path/to/item',
            'name'    => 'Item',
        ]);

        $this->assertInstanceOf('Krizalys\Onedrive\Resource\ItemReference', $itemReference);
        $this->assertSame('1', $itemReference->getDriveId());
        $this->assertSame('2', $itemReference->getId());
        $this->assertSame('/path/to/item', $itemReference->getPath());
        $this->assertSame('Item', $itemReference->getName());
    }
}
