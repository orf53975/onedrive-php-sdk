<?php

namespace Krizalys\Onedrive\Facet;

class Quota
{
    const STATE_NORMAL   = 'normal';
    const STATE_NEARING  = 'nearing';
    const STATE_CRITICAL = 'critical';
    const STATE_EXCEEDED = 'exceeded';

    /**
     * @var int
     *      The total space, in bytes.
     */
    private $total;

    /**
     * @var int
     *      The used space, in bytes.
     */
    private $used;

    /**
     * @var int
     *      The remaining space, in bytes.
     */
    private $remaining;

    /**
     * @var int
     *      The deleted space, in bytes.
     */
    private $deleted;

    /**
     * @var string
     *      The state.
     */
    private $state;

    /**
     * @var null|StoragePlanSet
     *      The storage plans.
     *
     * @internal Undocumented.
     */
    private $storagePlans;

    /**
     * @param int $total
     *        The total space, in bytes.
     * @param int $used
     *        The used space, in bytes.
     * @param int $remaining
     *        The remaining space, in bytes.
     * @param int $deleted
     *        The deleted space, in bytes.
     * @param string $state
     *        The state.
     * @param null|StoragePlanSet $storagePlans
     *        The storage plans.
     */
    public function __construct(
        $total = 0,
        $used = 0,
        $remaining = 0,
        $deleted = 0,
        $state = self::STATE_NORMAL,
        $storagePlans = null
    ) {
        $this->setTotal($total);
        $this->setUsed($used);
        $this->setRemaining($remaining);
        $this->setDeleted($deleted);
        $this->setState($state);
        $this->setStoragePlans($storagePlans);
    }

    /**
     * @param int $total
     *        The total space, in bytes.
     */
    public function setTotal($total)
    {
        $this->total = (int) $total;
    }

    /**
     * @return int
     *         The total space, in bytes.
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param int $used
     *        The used space, in bytes.
     */
    public function setUsed($used)
    {
        $this->used = (int) $used;
    }

    /**
     * @return int
     *         The used space, in bytes.
     */
    public function getUsed()
    {
        return $this->used;
    }

    /**
     * @param int $remaining
     *        The remaining space, in bytes.
     */
    public function setRemaining($remaining)
    {
        $this->remaining = (int) $remaining;
    }

    /**
     * @return int
     *         The remaining space, in bytes.
     */
    public function getRemaining()
    {
        return $this->remaining;
    }

    /**
     * @param int $deleted
     *        The deleted space, in bytes.
     */
    public function setDeleted($deleted)
    {
        $this->deleted = (int) $deleted;
    }

    /**
     * @return int
     *         The deleted space, in bytes.
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param string $state
     *        The state.
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return string
     *         The state.
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param null|StoragePlanSet $storagePlans
     *        The storage plans.
     */
    public function setStoragePlans(StoragePlanSet $storagePlans = null)
    {
        $this->storagePlans = $storagePlans;
    }

    /**
     * @return null|StoragePlanSet
     *         The storage plans.
     */
    public function getStoragePlans()
    {
        return $this->storagePlans;
    }
}
