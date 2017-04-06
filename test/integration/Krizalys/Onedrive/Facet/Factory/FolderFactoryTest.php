<?php

namespace Test\Integration\Krizalys\Onedrive\Facet\Factory;

use Krizalys\Onedrive\Facet\Factory\FolderFactory;

class FolderFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateFromProperties()
    {
        $folderFactory = new FolderFactory();

        $folder = $folderFactory->createFromProperties((object) [
            'childCount' => '1',
        ]);

        $this->assertInstanceOf('Krizalys\Onedrive\Facet\Folder', $folder);
        $this->assertSame(1, $folder->getChildCount());
    }
}
