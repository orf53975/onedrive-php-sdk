<?php

namespace Krizalys\Onedrive\Proxy;

use Microsoft\Graph\Graph;
use Microsoft\Graph\Model\ItemReference;

class ItemReferenceProxy
{
    /**
     * @var Graph
     *
     */
    private $graph;

    /**
     * @var ItemReference
     *
     */
    private $itemReference;

    /**
     * @param Graph $graph
     *
     * @param ItemReference $itemReference
     *
     */
    public function __construct(Graph $graph, ItemReference $itemReference)
    {
        $this->graph         = $graph;
        $this->itemReference = $itemReference;
    }

    /**
     * @param string $name
     *        The name.
     *
     * @return mixed
     *         The value.
     */
    public function __get($name)
    {
        switch ($name) {
            case 'id':
                return $this->itemReference->getId();

            case 'driveId':
                return $this->itemReference->getDriveId();

            case 'driveType':
                return $this->itemReference->getDriveType();

            default:
                throw new \Exception("Undefined property: $name");
        }
    }
}
