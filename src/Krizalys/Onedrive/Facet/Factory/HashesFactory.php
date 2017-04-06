<?php

namespace Krizalys\Onedrive\Facet\Factory;

use Krizalys\Onedrive\Facet\Hashes;

class HashesFactory
{
    /**
     * @var array
     *      The mappings.
     */
    private static $mappings = [
        'crc32Hash'    => 'crc32Hash',
        'sha1Hash'     => 'sha1Hash',
        'quickXorHash' => 'quickXorHash',
    ];

    /**
     * @param object $properties
     *        The properties.
     *
     * @return Hashes
     *         The hashes.
     */
    public function createFromProperties($properties)
    {
        $hashes = new Hashes();

        foreach (static::$mappings as $property => $setterSuffix) {
            if (property_exists($properties, $property)) {
                $setter = 'set' . ucfirst($setterSuffix);
                call_user_func([$hashes, $setter], $properties->{$property});
            }
        }

        return $hashes;
    }
}
