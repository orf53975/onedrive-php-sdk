<?php

namespace Krizalys\Onedrive\Facet;

class FileSystemInfo
{
    /**
     * @var null|\DateTimeInterface
     *      The created date time.
     */
    private $createdDateTime;

    /**
     * @var null|\DateTimeInterface
     *      The last accessed date time.
     */
    private $lastAccessedDateTime;

    /**
     * @var null|\DateTimeInterface
     *      The last modified date time.
     */
    private $lastModifiedDateTime;

    /**
     * @param null|\DateTimeInterface $createdDateTime
     *        The created date time.
     * @param null|\DateTimeInterface $lastAccessedDateTime
     *        The last accessed date time.
     * @param null|\DateTimeInterface $lastModifiedDateTime
     *        The last modified date time.
     */
    public function __construct(
        \DateTimeInterface $createdDateTime = null,
        \DateTimeInterface $lastAccessedDateTime = null,
        \DateTimeInterface $lastModifiedDateTime = null
    ) {
        $this->setCreatedDateTime($createdDateTime);
        $this->setLastAccessedDateTime($lastAccessedDateTime);
        $this->setLastModifiedDateTime($lastModifiedDateTime);
    }

    /**
     * @param null|\DateTimeInterface $createdDateTime
     *        The created date time.
     */
    public function setCreatedDateTime(\DateTimeInterface $createdDateTime = null)
    {
        $this->createdDateTime = $createdDateTime;
    }

    /**
     * @return null|\DateTimeInterface
     *         The created date time.
     */
    public function getCreatedDateTime()
    {
        return $this->createdDateTime;
    }

    /**
     * @param null|\DateTimeInterface $lastAccessedDateTime
     *        The last accessed date time.
     */
    public function setLastAccessedDateTime(\DateTimeInterface $lastAccessedDateTime = null)
    {
        $this->lastAccessedDateTime = $lastAccessedDateTime;
    }

    /**
     * @return null|\DateTimeInterface
     *         The last accessed date time.
     */
    public function getLastAccessedDateTime()
    {
        return $this->lastAccessedDateTime;
    }

    /**
     * @param null|\DateTimeInterface $lastModifiedDateTime
     *        The last modified date time.
     */
    public function setLastModifiedDateTime(\DateTimeInterface $lastModifiedDateTime = null)
    {
        $this->lastModifiedDateTime = $lastModifiedDateTime;
    }

    /**
     * @return null|\DateTimeInterface
     *         The last modified date time.
     */
    public function getLastModifiedDateTime()
    {
        return $this->lastModifiedDateTime;
    }
}
