<?php

namespace Krizalys\Onedrive\Proxy;

use Microsoft\Graph\Graph;
use Microsoft\Graph\Model\Drive;

class DriveProxy
{
    /**
     * @var Graph
     *
     */
    private $graph;

    /**
     * @var Drive
     *
     */
    private $drive;

    /**
     * @param Graph $graph
     *
     * @param Drive $drive
     *
     */
    public function __construct(Graph $graph, Drive $drive)
    {
        $this->graph = $graph;
        $this->drive = $drive;
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
                return $this->drive->getId();

            case 'createdDateTime':
                return $this->drive->getCreatedDateTime();

            case 'description':
                return $this->drive->getDescription();

            case 'driveType':
                return $this->drive->getDriveType();

            case 'lastModifiedDateTime':
                return $this->drive->getLastModifiedDateTime();

            case 'name':
                return $this->drive->getName();

            case 'quota':
                $quota = $this->drive->getQuota();
                return $quota !== null ? new QuotaProxy($this->graph, $quota) : null;

            case 'root':
                $root = $this->drive->getRoot();
                return $root !== null ? new DriveItemProxy($this->graph, $root) : null;

            case 'webUrl':
                return $this->drive->getWebUrl();

            default:
                throw new \Exception("Undefined property: $name");
        }
    }
}
