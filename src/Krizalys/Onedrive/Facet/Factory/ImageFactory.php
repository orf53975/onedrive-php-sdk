<?php

namespace Krizalys\Onedrive\Facet\Factory;

use Krizalys\Onedrive\Facet\Image;

class ImageFactory
{
    /**
     * @var array
     *      The mappings.
     */
    private static $mappings = [
        'width'  => 'width',
        'height' => 'height',
    ];

    /**
     * @param object $properties
     *        The properties.
     *
     * @return Image
     *         The image.
     */
    public function createFromProperties($properties)
    {
        $image = new Image();

        foreach (static::$mappings as $property => $setterSuffix) {
            if (property_exists($properties, $property)) {
                $setter = 'set' . ucfirst($setterSuffix);
                call_user_func([$image, $setter], $properties->{$property});
            }
        }

        return $image;
    }
}
