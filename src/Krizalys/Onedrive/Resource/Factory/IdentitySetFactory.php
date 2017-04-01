<?php

namespace Krizalys\Onedrive\Resource\Factory;

use Krizalys\Onedrive\Resource\IdentitySet;

class IdentitySetFactory
{
    /**
     * @var IdentityFactory
     *      The identity factory.
     */
    private $identityFactory;

    /**
     * @param IdentityFactory $identityFactory
     *        The identity factory.
     */
    public function __construct(IdentityFactory $identityFactory)
    {
        $this->identityFactory = $identityFactory;
    }

    /**
     * @param object $properties
     *        The properties.
     *
     * @return IdentitySet
     *         The identity set.
     */
    public function createFromProperties($properties)
    {
        $identitySet = new IdentitySet();

        if (property_exists($properties, 'user')) {
            $user = $this->identityFactory->createFromProperties($properties->user);
            $identitySet->setUser($user);
        }

        if (property_exists($properties, 'application')) {
            $application = $this->identityFactory->createFromProperties($properties->application);
            $identitySet->setApplication($application);
        }

        if (property_exists($properties, 'device')) {
            $device = $this->identityFactory->createFromProperties($properties->device);
            $identitySet->setDevice($device);
        }

        if (property_exists($properties, 'organization')) {
            $organization = $this->identityFactory->createFromProperties($properties->organization);
            $identitySet->setOrganization($organization);
        }

        return $identitySet;
    }
}
