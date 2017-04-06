<?php

namespace Krizalys\Onedrive\Facet\Factory;

use Krizalys\Onedrive\Facet\Audio;

class AudioFactory
{
    /**
     * @var array
     *      The mappings.
     */
    private static $mappings = [
        'album'             => 'album',
        'albumArtist'       => 'albumArtist',
        'artist'            => 'artist',
        'bitrate'           => 'bitrate',
        'composers'         => 'composers',
        'copyright'         => 'copyright',
        'disc'              => 'disc',
        'discCount'         => 'discCount',
        'duration'          => 'duration',
        'genre'             => 'genre',
        'hasDrm'            => 'hasDrm',
        'isVariableBitrate' => 'variableBitrate',
        'title'             => 'title',
        'track'             => 'track',
        'trackCount'        => 'trackCount',
        'year'              => 'year',
    ];

    /**
     * @param object $properties
     *        The properties.
     *
     * @return Audio
     *         The audio.
     */
    public function createFromProperties($properties)
    {
        $audio = new Audio();

        foreach (static::$mappings as $property => $setterSuffix) {
            if (property_exists($properties, $property)) {
                $setter = 'set' . ucfirst($setterSuffix);
                call_user_func([$audio, $setter], $properties->{$property});
            }
        }

        return $audio;
    }
}
