<?php

namespace Krizalys\Onedrive\Facet\Factory;

use Krizalys\Onedrive\Facet\File;

class FileFactory
{
    /**
     * @var array
     *      The mappings.
     */
    private static $mappings = [
        'mimeType'           => 'mimeType',
        'processingMetadata' => 'processingMetadata',
    ];

    /**
     * @var HashesFactory
     *      The hashes factory.
     */
    private $hashesFactory;

    /**
     * @param HashesFactory $hashesFactory
     *        The hashes factory.
     */
    public function __construct(HashesFactory $hashesFactory)
    {
        $this->hashesFactory = $hashesFactory;
    }

    /**
     * @param object $properties
     *        The properties.
     *
     * @return File
     *         The file.
     */
    public function createFromProperties($properties)
    {
        $file = new File();

        foreach (static::$mappings as $property => $setterSuffix) {
            if (property_exists($properties, $property)) {
                $setter = 'set' . ucfirst($setterSuffix);
                call_user_func([$file, $setter], $properties->{$property});
            }
        }

        if (property_exists($properties, 'hashes')) {
            $hashes = $this->hashesFactory->createFromProperties($properties->hashes);
            $file->setHashes($hashes);
        }

        return $file;
    }
}
