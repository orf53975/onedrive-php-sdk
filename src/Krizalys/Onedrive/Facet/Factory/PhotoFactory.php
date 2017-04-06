<?php

namespace Krizalys\Onedrive\Facet\Factory;

use Krizalys\Onedrive\Facet\Photo;

class PhotoFactory
{
    /**
     * @var array
     *      The mappings.
     */
    private static $mappings = [
        'cameraMake'          => 'cameraMake',
        'cameraModel'         => 'cameraModel',
        'fNumber'             => 'fNumber',
        'exposureDenominator' => 'exposureDenominator',
        'exposureNumerator'   => 'exposureNumerator',
        'focalLength'         => 'focalLength',
        'iso'                 => 'iso',
    ];

    /**
     * @param object $properties
     *        The properties.
     *
     * @return Photo
     *         The photo.
     */
    public function createFromProperties($properties)
    {
        $photo = new Photo();

        foreach (static::$mappings as $property => $setterSuffix) {
            if (property_exists($properties, $property)) {
                $setter = 'set' . ucfirst($setterSuffix);
                call_user_func([$photo, $setter], $properties->{$property});
            }
        }

        if (property_exists($properties, 'takenDateTime')) {
            $takenDateTime = new \DateTime($properties->takenDateTime);
            $photo->setTakenDateTime($takenDateTime);
        }

        return $photo;
    }
}
