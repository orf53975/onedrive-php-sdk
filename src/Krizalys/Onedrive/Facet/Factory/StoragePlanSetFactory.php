<?php

namespace Krizalys\Onedrive\Facet\Factory;

use Krizalys\Onedrive\Facet\StoragePlanSet;

class StoragePlanSetFactory
{
    /**
     * @var array
     *      The mappings.
     */
    private static $mappings = [
        'upgradeAvailable' => 'upgradeAvailable',
    ];

    /**
     * @param object $properties
     *        The properties.
     *
     * @return StoragePlanSet
     *         The storage plan set.
     */
    public function createFromProperties($properties)
    {
        $storagePlanSet = new StoragePlanSet();

        foreach (static::$mappings as $property => $setterSuffix) {
            if (property_exists($properties, $property)) {
                $setter = 'set' . ucfirst($setterSuffix);
                call_user_func([$storagePlanSet, $setter], $properties->{$property});
            }
        }

        return $storagePlanSet;
    }
}
