<?php

namespace Krizalys\Onedrive\Facet\Factory;

use Krizalys\Onedrive\Facet\Video;

class VideoFactory
{
    /**
     * @var array
     *      The mappings.
     */
    private static $mappings = [
        'bitrate'  => 'bitrate',
        'duration' => 'duration',
        'height'   => 'height',
        'width'    => 'width',
    ];

    /**
     * @param object $properties
     *        The properties.
     *
     * @return Video
     *         The video.
     */
    public function createFromProperties($properties)
    {
        $video = new Video();

        foreach (static::$mappings as $property => $setterSuffix) {
            if (property_exists($properties, $property)) {
                $setter = 'set' . ucfirst($setterSuffix);
                call_user_func([$video, $setter], $properties->{$property});
            }
        }

        return $video;
    }
}
