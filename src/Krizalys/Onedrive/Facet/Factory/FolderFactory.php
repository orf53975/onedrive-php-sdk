<?php

namespace Krizalys\Onedrive\Facet\Factory;

use Krizalys\Onedrive\Facet\Folder;

class FolderFactory
{
    /**
     * @var array
     *      The mappings.
     */
    private static $mappings = [
        'childCount' => 'childCount',
    ];

    /**
     * @param object $properties
     *        The properties.
     *
     * @return Folder
     *         The folder.
     */
    public function createFromProperties($properties)
    {
        $folder = new Folder();

        foreach (static::$mappings as $property => $setterSuffix) {
            if (property_exists($properties, $property)) {
                $setter = 'set' . ucfirst($setterSuffix);
                call_user_func([$folder, $setter], $properties->{$property});
            }
        }

        return $folder;
    }
}
