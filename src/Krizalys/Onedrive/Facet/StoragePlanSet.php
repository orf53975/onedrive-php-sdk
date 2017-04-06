<?php

namespace Krizalys\Onedrive\Facet;

/**
 * @internal Undocumented.
 */
class StoragePlanSet
{
    /**
     * @var bool
     *      Whether an upgrade is available.
     */
    private $upgradeAvailable;

    /**
     * @param bool $upgradeAvailable
     *        Whether an upgrade is available.
     */
    public function __construct($upgradeAvailable = false)
    {
        $this->setUpgradeAvailable($upgradeAvailable);
    }

    /**
     * @param bool $upgradeAvailable
     *        Whether an upgrade is available.
     */
    public function setUpgradeAvailable($upgradeAvailable)
    {
        $this->upgradeAvailable = (bool) $upgradeAvailable;
    }

    /**
     * @return bool
     *         Whether an upgrade is available.
     */
    public function isUpgradeAvailable()
    {
        return $this->upgradeAvailable;
    }
}
