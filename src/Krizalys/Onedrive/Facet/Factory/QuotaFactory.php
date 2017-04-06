<?php

namespace Krizalys\Onedrive\Facet\Factory;

use Krizalys\Onedrive\Facet\Quota;

class QuotaFactory
{
    /**
     * @var array
     *      The mappings.
     */
    private static $mappings = [
        'total'     => 'total',
        'used'      => 'used',
        'remaining' => 'remaining',
        'deleted'   => 'deleted',
        'state'     => 'state',
    ];

    private $storagePlanSetFactory;

    public function __construct(StoragePlanSetFactory $storagePlanSetFactory)
    {
        $this->storagePlanSetFactory = $storagePlanSetFactory;
    }

    /**
     * @param object $properties
     *        The properties.
     *
     * @return Quota
     *         The quota.
     */
    public function createFromProperties($properties)
    {
        $quota = new Quota();

        foreach (static::$mappings as $property => $setterSuffix) {
            if (property_exists($properties, $property)) {
                $setter = 'set' . ucfirst($setterSuffix);
                call_user_func([$quota, $setter], $properties->{$property});
            }
        }

        if (property_exists($properties, 'storagePlans')) {
            $storagePlans = $this->storagePlanSetFactory->createFromProperties($properties->storagePlans);
            $quota->setStoragePlans($storagePlans);
        }

        return $quota;
    }
}
