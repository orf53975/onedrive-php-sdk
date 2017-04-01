<?php

namespace Krizalys\Onedrive\Resource;

class ItemReference
{
    /**
     * @var string
     *      The drive ID.
     */
    private $driveId;

    /**
     * @var string
     *      The ID.
     */
    private $id;

    /**
     * @var string
     *      The path.
     */
    private $path;

    /**
     * @var string
     *      The name.
     */
    private $name;

    /**
     * @param string $driveId
     *        The drive ID.
     * @param string $id
     *        The ID.
     * @param string $path
     *        The path.
     * @param string $name
     *        The name.
     */
    public function __construct(
        $driveId = '',
        $id = '',
        $path = '',
        $name = ''
    ) {
        $this->setDriveId($driveId);
        $this->setId($id);
        $this->setPath($path);
        $this->setName($name);
    }

    /**
     * @param string $driveId
     *        The drive ID.
     */
    public function setDriveId($driveId)
    {
        $this->driveId = (string) $driveId;
    }

    /**
     * @return string
     *         The drive ID.
     */
    public function getDriveId()
    {
        return $this->driveId;
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
     * @param string $path
     *        The path.
     */
    public function setPath($path)
    {
        $this->path = (string) $path;
    }

    /**
     * @return string
     *         The path.
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @param string $name
     *        The name.
     */
    public function setName($name)
    {
        $this->name = (string) $name;
    }

    /**
     * @return string
     *         The name.
     */
    public function getName()
    {
        return $this->name;
    }
}
