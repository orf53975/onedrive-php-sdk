<?php

namespace Krizalys\Onedrive\Facet\Factory;

use Krizalys\Onedrive\Facet\RemoteItem;

class RemoteItemFactory
{
    /**
     * @var array
     *      The mappings.
     */
    private static $mappings = [
//        'createdBy'            => (object) [],
//        'file'                 => (object) [],
//        'fileSystemInfo'       => (object) [],
//        'folder'               => (object) [],
        'id'                   => 'id',
//        'lastModifiedBy'       => (object) [],
        'name'                 => 'name',
//        'parentReference'      => (object) [],
//        'shared'               => (object) [],
        'size'                 => 'size',
        'webUrl'               => 'webUrl',
    ];

    /**
     * @var IdentitySetFactory
     *      The identity set factory.
     */
    private $identitySetFactory;

    /**
     * @var FileFactory
     *      The file factory.
     */
    private $fileFactory;

    /**
     * @var FileSystemInfoFactory
     *      The file system info factory.
     */
    private $fileSystemInfoFactory;

    /**
     * @var FolderFactory
     *      The folder factory.
     */
    private $folderFactory;

    /**
     * @var ItemReferenceFactory
     *      The item reference factory.
     */
    private $itemReferenceFactory;

    /**
     * @var SharedFactory
     *      The shared factory.
     */
    private $sharedFactory;

    /**
     * @param IdentitySetFactory $identitySetFactory
     *        The identity set factory.
     * @param FileFactory $fileFactory
     *        The file factory.
     * @param FileSystemInfoFactory $fileSystemInfoFactory
     *        The file system info factory.
     * @param FolderFactory $folderFactory
     *        The folder factory.
     * @param ItemReferenceFactory $itemReferenceFactory
     *        The item reference factory.
     * @param SharedFactory $sharedFactory
     *        The shared factory.
     */
    public function __construct(
        IdentitySetFactory $identitySetFactory,
        FileFactory $fileFactory,
        FileSystemInfoFactory $fileSystemInfoFactory,
        FolderFactory $folderFactory,
        ItemReferenceFactory $itemReferenceFactory,
        SharedFactory $sharedFactory
    ) {
        $this->identitySetFactory    = $identitySetFactory;
        $this->fileFactory           = $fileFactory;
        $this->fileSystemInfoFactory = $fileSystemInfoFactory;
        $this->folderFactory         = $folderFactory;
        $this->itemReferenceFactory  = $itemReferenceFactory;
        $this->sharedFactory         = $sharedFactory;
    }

    /**
     * @param object $properties
     *        The properties.
     *
     * @return RemoteItem
     *         The remote item.
     */
    public function createFromProperties($properties)
    {
        $remoteItem = new RemoteItem();

        foreach (static::$mappings as $property => $setterSuffix) {
            if (property_exists($properties, $property)) {
                $setter = 'set' . ucfirst($setterSuffix);
                call_user_func([$remoteItem, $setter], $properties->{$property});
            }
        }

        if (property_exists($properties, 'lastModifiedDateTime')) {
            $lastModifiedDateTime = new \DateTime($properties->lastModifiedDateTime);
            $remoteItem->setLastModifiedDateTime($lastModifiedDateTime);
        }

        return $remoteItem;
    }
}
