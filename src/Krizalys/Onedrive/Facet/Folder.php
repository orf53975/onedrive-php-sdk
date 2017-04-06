<?php

namespace Krizalys\Onedrive\Facet;

class Folder
{
    /**
     * @var int
     *      The child count.
     */
    private $childCount;

    /**
     * @param int $childCount
     *        The child count.
     */
    public function __construct($childCount = 0)
    {
        $this->setChildCount($childCount);
    }

    /**
     * @param int $childCount
     *        The child count.
     */
    public function setChildCount($childCount)
    {
        $this->childCount = (int) $childCount;
    }

    /**
     * @return int
     *         The child count.
     */
    public function getChildCount()
    {
        return $this->childCount;
    }
}
