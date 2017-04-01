<?php

namespace Krizalys\Onedrive\Resource\Factory;

use Krizalys\Onedrive\Resource\ItemReference;

class ItemReferenceFactory
{
    /**
     * @var array
     *      The mappings.
     */
    private static $mappings = [
        'driveId' => 'driveId',
        'id'      => 'id',
        'path'    => 'path',
        'name'    => 'name',
    ];

    /**
     * @param object $properties
     *        The properties.
     *
     * @return ItemReference
     *         The item reference.
     */
    public function createFromProperties($properties)
    {
        $itemReference = new ItemReference();

        foreach (static::$mappings as $property => $setterSuffix) {
            if (property_exists($properties, $property)) {
                $setter = 'set' . ucfirst($setterSuffix);
                call_user_func([$itemReference, $setter], $properties->{$property});
            }
        }

        return $itemReference;
    }
}
