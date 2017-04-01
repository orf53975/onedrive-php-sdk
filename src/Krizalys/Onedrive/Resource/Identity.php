<?php

namespace Krizalys\Onedrive\Resource;

class Identity
{
    /**
     * @var string
     *      The ID.
     */
    private $id;

    /**
     * @var string
     *      The display name.
     */
    private $displayName;

    /**
     * @var null|ThumbnailSet
     *      The thumbnails.
     */
    private $thumbnails;

    /**
     * @param string $id
     *        The ID.
     * @param string $displayName
     *        The display name.
     * @param null|ThumbnailSet $thumbnails
     *        The thumbnails.
     */
    public function __construct(
        $id = '',
        $displayName = '',
        ThumbnailSet $thumbnails = null
    ) {
        $this->setId($id);
        $this->setDisplayName($displayName);
        $this->setThumbnails($thumbnails);
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
     * @param string $displayName
     *        The display name.
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = (string) $displayName;
    }

    /**
     * @return string
     *         The display name.
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * @param null|ThumbnailSet $thumbnails
     *        The thumbnails.
     */
    public function setThumbnails(ThumbnailSet $thumbnails = null)
    {
        $this->thumbnails = $thumbnails;
    }

    /**
     * @param null|ThumbnailSet
     *        The thumbnails.
     */
    public function getThumbnails()
    {
        return $this->thumbnails;
    }
}
