<?php

namespace Krizalys\Onedrive\Facet\Factory;

use Krizalys\Onedrive\Facet\FileSystemInfo;

class FileSystemInfoFactory
{
    /**
     * @var array
     *      The mappings.
     */
    private static $mappings = [
        //'createdDateTime'      => 'createdDateTime',
        //'lastAccessedDateTime' => 'lastAccessedDateTime',
        //'lastModifiedDateTime' => 'lastModifiedDateTime',
    ];

    /**
     * @param object $properties
     *        The properties.
     *
     * @return FileSystemInfo
     *         The file system information.
     */
    public function createFromProperties($properties)
    {
        $fileSystemInfo = new FileSystemInfo();

        if (property_exists($properties, 'createdDateTime')) {
            $createdDateTime = new \DateTime($properties->createdDateTime);
            $fileSystemInfo->setCreatedDateTime($createdDateTime);
        }

        if (property_exists($properties, 'lastAccessedDateTime')) {
            $lastAccessedDateTime = new \DateTime($properties->lastAccessedDateTime);
            $fileSystemInfo->setLastAccessedDateTime($lastAccessedDateTime);
        }

        if (property_exists($properties, 'lastModifiedDateTime')) {
            $lastModifiedDateTime = new \DateTime($properties->lastModifiedDateTime);
            $fileSystemInfo->setLastModifiedDateTime($lastModifiedDateTime);
        }

        return $fileSystemInfo;
    }
}
