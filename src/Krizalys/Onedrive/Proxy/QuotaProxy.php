<?php

namespace Krizalys\Onedrive\Proxy;

use Microsoft\Graph\Graph;
use Microsoft\Graph\Model\Quota;

class QuotaProxy
{
    /**
     * @var Graph
     *
     */
    private $graph;

    /**
     * @var Quota
     *
     */
    private $quota;

    /**
     * @param Graph $graph
     *
     * @param Quota $quota
     *
     */
    public function __construct(Graph $graph, Quota $quota)
    {
        $this->graph = $graph;
        $this->quota = $quota;
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
            case 'deleted':
                return $this->quota->getDeleted();

            case 'remaining':
                return $this->quota->getRemaining();

            case 'state':
                return $this->quota->getState();

            case 'total':
                return $this->quota->getTotal();

            case 'used':
                return $this->quota->getUsed();

            default:
                throw new \Exception("Undefined property: $name");
        }
    }
}
