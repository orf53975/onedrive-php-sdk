<?php

namespace Krizalys\Onedrive\Resource;

use Krizalys\Onedrive\Facet\Quota;

class Drive
{
    const TYPE_PERSONAL   = 'personal';
    const TYPE_BUSINESS   = 'business';
    const TYPE_SHAREPOINT = 'documentLibrary';

    /**
     * @var string
     *      The ID.
     */
    private $id;

    /**
     * @var string
     *      The drive type.
     *
     * @todo Rename into $type.
     */
    private $driveType;

    /**
     * @var IdentitySet
     *      The owner.
     */
    private $owner;

    /**
     * @var Quota
     *      The quota.
     */
    private $quota;

    /**
     * @var
     *      The status.
     *
     * @internal Undocumented.
     */
    private $status;

    /**
     * @param string $id
     *        The ID.
     * @param string $type
     *        The drive type.
     * @param IdentitySet $owner
     *        The owner.
     * @param Quota $quota
     *        The quota.
     * @param $status
     *        The status.
     */
    public function __construct(
        $id = '',
        $type = self::TYPE_PERSONAL,
        IdentitySet $owner = null,
        Quota $quota = null,
        $status = null
    ) {
        $this->setId($id);
        $this->setDriveType($type);
        $this->setOwner($owner);
        $this->setQuota($quota);
        $this->setStatus($status);
    }

    /**
     * @param string $id
     *        The ID.
     */
    public function setId($id)
    {
        $this->id = (string) $id;
    }

    /**
     * @return string
     *         The ID.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $type
     *        The drive type.
     */
    public function setDriveType($type)
    {
        $this->driveType = (string) $type;
    }

    /**
     * @return string
     *         The drive type.
     */
    public function getDriveType()
    {
        return $this->driveType;
    }

    /**
     * @param IdentitySet $owner
     *        The owner.
     */
    public function setOwner(IdentitySet $owner = null)
    {
        $this->owner = $owner;
    }

    /**
     * @return IdentitySet
     *         The owner.
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param Quota $quota
     *        The quota.
     */
    public function setQuota(Quota $quota = null)
    {
        $this->quota = $quota;
    }

    /**
     * @return Quota
     *         The quota.
     */
    public function getQuota()
    {
        return $this->quota;
    }

    /**
     * @param $status
     *        The status.
     */
    public function setStatus($status = null)
    {
        $this->status = $status;
    }

    /**
     * @return
     *         The status.
     */
    public function getStatus()
    {
        return $this->status;
    }
}
