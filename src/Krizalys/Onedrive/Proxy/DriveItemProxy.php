<?php

namespace Krizalys\Onedrive\Proxy;

use GuzzleHttp\Psr7;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model\DriveItem;

class DriveItemProxy
{
    /**
     * @var Graph
     *      The graph.
     */
    private $graph;

    /**
     * @var DriveItem
     *      The drive item.
     */
    private $driveItem;

    /**
     * @param Graph
     *        The graph.
     * @param DriveItem
     *        The drive item.
     */
    public function __construct(Graph $graph, DriveItem $driveItem)
    {
        $this->graph     = $graph;
        $this->driveItem = $driveItem;
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
                return $this->driveItem->getId();

            case 'createdDateTime':
                return $this->driveItem->getCreatedDateTime();

            case 'eTag':
                return $this->driveItem->getETag();

            case 'lastModifiedDateTime':
                return $this->driveItem->getLastModifiedDateTime();

            case 'name':
                return $this->driveItem->getName();

            case 'parentReference':
                $parentReference = $this->driveItem->getParentReference();
                return $parentReference !== null ? new ItemReferenceProxy($this->graph, $parentReference) : null;

            case 'webUrl':
                return $this->driveItem->getWebUrl();

            case 'content':
                return $this->download();

            case 'cTag':
                return $this->driveItem->getCTag();

            case 'description':
                return $this->driveItem->getDescription();

            case 'webDavUrl':
                return $this->driveItem->getWebDavUrl();

            default:
                throw new \Exception("Undefined property: $name");
        }
    }

    /**
     * @param string $name
     *        The name.
     * @param array $options
     *        The options.
     *
     * @return DriveItemProxy
     *         The drive item created.
     */
    public function createFolder($name, array $options = [])
    {
        $locator  = "items/{$this->id}";
        $endpoint = "/me/drive/$locator/children";

        $defaultOptions = [
            'folder' => [
                '@odata.type' => 'microsoft.graph.folder',
            ],
            'name' => (string) $name,
        ];

        $response = $this
            ->graph
            ->createRequest('POST', $endpoint)
            ->attachBody($defaultOptions + $options)
            ->execute();

        $status = $response->getStatus();

        if ($status != 201) {
            throw new \Exception("Unexpected status code produced by 'POST $endpoint': $status");
        }

        $driveItem = $response->getResponseAsObject(DriveItem::class);

        return new DriveItemProxy($this->graph, $driveItem);
    }

    /**
     * @return array
     *         The child drive items.
     *
     * @todo Support pagination.
     */
    public function getChildren()
    {
        $locator  = "items/{$this->id}";
        $endpoint = "/me/drive/$locator/children";

        $response = $this
            ->graph
            ->createCollectionRequest('GET', $endpoint)
            ->execute();

        $status = $response->getStatus();

        if ($status != 200) {
            throw new \Exception("Unexpected status code produced by 'GET $endpoint': $status");
        }

        $driveItems = $response->getResponseAsObject(DriveItem::class);

        return array_map(function (DriveItem $driveItem) {
            return new DriveItemProxy($this->graph, $driveItem);
        }, $driveItems);
    }

    /**
     */
    public function delete()
    {
        $locator  = "items/{$this->id}";
        $endpoint = "/me/drive/$locator";

        $response = $this
            ->graph
            ->createRequest('DELETE', $endpoint)
            ->execute();

        $status = $response->getStatus();

        if ($status != 204) {
            throw new \Exception("Unexpected status code produced by 'DELETE $endpoint': $status");
        }
    }

    /**
     * @param string $name
     *        The name.
     * @param string|resource $content
     *        The content.
     * @param array $options
     *        The options.
     *
     * @return DriveItemProxy
     *         The drive item created.
     *
     * @todo Support content type in options.
     */
    public function upload($name, $content, array $options = [])
    {
        $locator  = "items/{$this->id}";
        $endpoint = "/me/drive/$locator:/$name:/content";

        $response = $this
            ->graph
            ->createRequest('PUT', $endpoint)
            ->addHeaders($options)
            ->attachBody(is_resource($content) ? $content : Psr7\stream_for($content))
            ->execute();

        $status = $response->getStatus();

        if ($status != 201) {
            throw new \Exception("Unexpected status code produced by 'PUT $endpoint': $status");
        }

        $driveItem = $response->getResponseAsObject(DriveItem::class);

        return new DriveItemProxy($this->graph, $driveItem);
    }

    /**
     * @return string
     *         The content.
     *
     * @todo Also support returning stream.
     */
    public function download()
    {
        $locator  = "items/{$this->id}";
        $endpoint = "/me/drive/$locator/content";

        $response = $this
            ->graph
            ->createRequest('GET', $endpoint)
            ->execute();

        $status = $response->getStatus();

        if ($status != 200) {
            throw new \Exception("Unexpected status code produced by 'GET $endpoint': $status");
        }
        var_export($response->getRawBody());
        return $response->getRawBody();
    }

    /**
     * @param DriveItemProxy $destinationItem
     *        The destination item.
     * @param array $options
     *        The options.
     *
     * @return DriveItemProxy
     *         The drive item.
     */
    public function move(DriveItemProxy $destinationItem, array $options = [])
    {
        $locator  = "items/{$this->id}";
        $endpoint = "/me/drive/$locator";

        $defaultOptions = [
            'parentReference' => [
                'id' => $destinationItem->id,
            ],
        ];

        $response = $this
            ->graph
            ->createRequest('PATCH', $endpoint)
            ->attachBody($defaultOptions + $options)
            ->execute();

        $status = $response->getStatus();

        if ($status != 200) {
            throw new \Exception("Unexpected status code produced by 'PATCH $endpoint': $status");
        }

        $driveItem = $response->getResponseAsObject(DriveItem::class);

        return new DriveItemProxy($this->graph, $driveItem);
    }

    /**
     * @param DriveItemProxy $destinationItem
     *        The destination item.
     * @param array $options
     *        The options.
     *
     * @return string
     *         The progress URI.
     */
    public function copy(DriveItemProxy $destinationItem, array $options = [])
    {
        $locator  = "items/{$this->id}";
        $endpoint = "/me/drive/$locator/copy";

        $defaultOptions = [
            'parentReference' => [
                'id' => $destinationItem->id,
            ],
        ];

        $response = $this
            ->graph
            ->createRequest('POST', $endpoint)
            ->attachBody($defaultOptions + $options)
            ->execute();

        $status = $response->getStatus();

        if ($status != 202) {
            throw new \Exception("Unexpected status code produced by 'POST $endpoint': $status");
        }

        $headers = $response->getHeaders();

        return $headers['Location'][0];
    }
}
