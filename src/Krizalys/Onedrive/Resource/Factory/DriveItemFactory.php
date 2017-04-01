<?php

namespace Krizalys\Onedrive\Resource\Factory;

use Krizalys\Onedrive\Resource\DriveItem;

class DriveItemFactory
{
    /**
     * @var array
     *      The mappings.
     */
    private static $mappings = [];

    /**
     * @param object $properties
     *        The properties.
     *
     * @return DriveItem
     *         The drive item.
     */
    public function createFromProperties($properties)
    {
        $driveItem = new DriveItem();

        foreach (static::$mappings as $property => $setterSuffix) {
            if (property_exists($properties, $property)) {
                $setter = 'set' . ucfirst($setterSuffix);
                call_user_func([$driveItem, $setter], $properties->{$property});
            }
        }

        return $driveItem;
    }
}
