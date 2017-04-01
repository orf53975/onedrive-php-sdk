<?php

namespace Krizalys\Onedrive\Resource\Factory;

use Krizalys\Onedrive\Resource\ThumbnailSet;

class ThumbnailSetFactory
{
    /**
     * @var array
     *      The mappings.
     */
    private static $mappings = [
        'id' => 'id',
    ];

    /**
     * @var ThumbnailFactory
     *      The thumbnail factory.
     */
    private $thumbnailFactory;

    /**
     * @param ThumbnailFactory $thumbnailFactory
     *        The thumbnail factory.
     */
    public function __construct(ThumbnailFactory $thumbnailFactory)
    {
        $this->thumbnailFactory = $thumbnailFactory;
    }

    /**
     * @param object $properties
     *        The properties.
     *
     * @return ThumbnailSet
     *         The thumbnail set.
     */
    public function createFromProperties($properties)
    {
        $thumbnailSet = new ThumbnailSet();

        foreach (static::$mappings as $property => $setterSuffix) {
            if (property_exists($properties, $property)) {
                $setter = 'set' . ucfirst($setterSuffix);
                call_user_func([$thumbnailSet, $setter], $properties->{$property});
            }
        }

        if (property_exists($properties, 'small')) {
            $small = $this->thumbnailFactory->createFromProperties($properties->small);
            $thumbnailSet->setSmall($small);
        }

        if (property_exists($properties, 'medium')) {
            $medium = $this->thumbnailFactory->createFromProperties($properties->medium);
            $thumbnailSet->setMedium($medium);
        }

        if (property_exists($properties, 'large')) {
            $large = $this->thumbnailFactory->createFromProperties($properties->large);
            $thumbnailSet->setLarge($large);
        }

        if (property_exists($properties, 'source')) {
            $source = $this->thumbnailFactory->createFromProperties($properties->source);
            $thumbnailSet->setSource($source);
        }

        return $thumbnailSet;
    }
}
