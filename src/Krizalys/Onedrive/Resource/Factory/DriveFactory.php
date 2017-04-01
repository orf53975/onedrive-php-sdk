<?php

namespace Krizalys\Onedrive\Resource\Factory;

use Krizalys\Onedrive\Facet\Factory\QuotaFactory;
use Krizalys\Onedrive\Resource\Drive;

class DriveFactory
{
    public function __construct(
        IdentitySetFactory $identitySetFactory,
        QuotaFactory $quotaFactory
    ) {
        $this->identitySetFactory = $identitySetFactory;
        $this->quotaFactory       = $quotaFactory;
    }

    public function create($driveValues)
    {
        $drive = new Drive();

        if (property_exists($driveValues, 'id')) {
            $drive->setId($driveValues->id);
        }

        if (property_exists($driveValues, 'driveType')) {
            $drive->setDriveType($driveValues->driveType);
        }

        if (property_exists($driveValues, 'owner')) {
            $owner = $this->identitySetFactory->createFromProperties($driveValues->owner);
            $drive->setOwner($owner);
        }

        if (property_exists($driveValues, 'quota')) {
            $quota = $this->quotaFactory->createFromProperties($driveValues->quota);
            $drive->setQuota($quota);
        }

        if (property_exists($driveValues, 'status')) {
            $drive->setStatus($driveValues->status);
        }

        return $drive;
    }
}
