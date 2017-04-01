<?php

namespace Krizalys\Onedrive\Resource;

class ThumbnailSet
{
    /**
     * @var string
     *      The ID.
     */
    private $id;

    /**
     * @var null|Thumbnail
     *      The small thumbnail.
     */
    private $small;

    /**
     * @var null|Thumbnail
     *      The medium thumbnail.
     */
    private $medium;

    /**
     * @var null|Thumbnail
     *      The large thumbnail.
     */
    private $large;

    /**
     * @var null|Thumbnail
     *      The source thumbnail.
     */
    private $source;

    /**
     * @param string $id
     *        The ID.
     * @param null|Thumbnail $small
     *        The small thumbnail.
     * @param null|Thumbnail $medium
     *        The medium thumbnail.
     * @param null|Thumbnail $large
     *        The large thumbnail.
     * @param null|Thumbnail $source
     *        The source thumbnail.
     */
    public function __construct(
        $id = '',
        Thumbnail $small = null,
        Thumbnail $medium = null,
        Thumbnail $large = null,
        Thumbnail $source = null
    ) {
        $this->setId($id);
        $this->setSmall($small);
        $this->setMedium($medium);
        $this->setLarge($large);
        $this->setSource($source);
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
     * @param null|Thumbnail $small
     *        The small thumbnail.
     */
    public function setSmall(Thumbnail $small = null)
    {
        $this->small = $small;
    }

    /**
     * @return null|Thumbnail
     *         The small thumbnail.
     */
    public function getSmall()
    {
        return $this->small;
    }

    /**
     * @param null|Thumbnail $medium
     *        The medium thumbnail.
     */
    public function setMedium(Thumbnail $medium = null)
    {
        $this->medium = $medium;
    }

    /**
     * @return null|Thumbnail
     *         The medium thumbnail.
     */
    public function getMedium()
    {
        return $this->medium;
    }

    /**
     * @param null|Thumbnail $large
     *        The large thumbnail.
     */
    public function setLarge(Thumbnail $large = null)
    {
        $this->large = $large;
    }

    /**
     * @return null|Thumbnail
     *         The large thumbnail.
     */
    public function getLarge()
    {
        return $this->large;
    }

    /**
     * @param null|Thumbnail $source
     *        The source thumbnail.
     */
    public function setSource(Thumbnail $source = null)
    {
        $this->source = $source;
    }

    /**
     * @return null|Thumbnail
     *         The source thumbnail.
     */
    public function getSource()
    {
        return $this->source;
    }
}
