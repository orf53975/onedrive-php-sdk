<?php

namespace Krizalys\Onedrive\Resource\Factory;

use Krizalys\Onedrive\Resource\Thumbnail;

class ThumbnailFactory
{
    /**
     * @var array
     *      The mappings.
     */
    private static $mappings = [
        'width'  => 'width',
        'height' => 'height',
        //'url'    => 'url',
    ];

    /**
     * @param object $properties
     *        The properties.
     *
     * @return Thumbnail
     *         The thumbnail.
     */
    public function createFromProperties($properties)
    {
        $thumbnail = new Thumbnail();

        foreach (static::$mappings as $property => $setterSuffix) {
            if (property_exists($properties, $property)) {
                $setter = 'set' . ucfirst($setterSuffix);
                call_user_func([$thumbnail, $setter], $properties->{$property});
            }
        }

        return $thumbnail;
    }
}
