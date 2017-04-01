<?php

namespace Krizalys\Onedrive\Resource\Factory;

use Krizalys\Onedrive\Resource\Identity;

class IdentityFactory
{
    /**
     * @var array
     *      The mappings.
     */
    private static $mappings = [
        'id'          => 'id',
        'displayName' => 'displayName',
    ];

    /**
     * @var ThumbnailSetFactory
     *      The thumbnail set factory.
     */
    private $thumbnailSetFactory;

    /**
     * @param ThumbnailSetFactory $thumbnailSetFactory
     *        The thumbnail set factory.
     */
    public function __construct(ThumbnailSetFactory $thumbnailSetFactory)
    {
        $this->thumbnailSetFactory = $thumbnailSetFactory;
    }

    /**
     * @param object $properties
     *        The properties.
     *
     * @return Identity
     *         The identity.
     */
    public function createFromProperties($properties)
    {
        $identity = new Identity();

        foreach (static::$mappings as $property => $setterSuffix) {
            if (property_exists($properties, $property)) {
                $setter = 'set' . ucfirst($setterSuffix);
                call_user_func([$identity, $setter], $properties->{$property});
            }
        }

        if (property_exists($properties, 'thumbnails')) {
            $thumbnails = $this->thumbnailSetFactory->createFromProperties($properties->thumbnails);
            $identity->setThumbnails($thumbnails);
        }

        return $identity;
    }
}
