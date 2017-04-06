<?php

namespace Krizalys\Onedrive\Facet\Factory;

use Krizalys\Onedrive\Facet\Location;

class LocationFactory
{
    /**
     * @var array
     *      The mappings.
     */
    private static $mappings = [
        'altitude'  => 'altitude',
        'latitude'  => 'latitude',
        'longitude' => 'longitude',
    ];

    /**
     * @param object $properties
     *        The properties.
     *
     * @return Location
     *         The location.
     */
    public function createFromProperties($properties)
    {
        $location = new Location();

        foreach (static::$mappings as $property => $setterSuffix) {
            if (property_exists($properties, $property)) {
                $setter = 'set' . ucfirst($setterSuffix);
                call_user_func([$location, $setter], $properties->{$property});
            }
        }

        return $location;
    }
}
