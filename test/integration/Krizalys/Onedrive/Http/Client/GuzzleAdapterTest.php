<?php

namespace Test\Unit\Krizalys\Onedrive\Http\Client;

use GuzzleHttp\Client as GuzzleClient;
use Krizalys\Onedrive\Http\Client\GuzzleAdapter;
use Krizalys\Onedrive\Http\Connection;
use Krizalys\Onedrive\Http\Stream\MemoryStream;

class GuzzleAdapterTest extends \PHPUnit_Framework_TestCase
{
    public function testGet()
    {
        $guzzleClient = $this->buildGuzzleClient();
        $adapter      = new GuzzleAdapter($guzzleClient);
        $connection   = new Connection('www.google.com');
        $actual       = $adapter->get($connection, '/');
        $this->assertInstanceOf('Psr\Http\Message\ResponseInterface', $actual);
    }

    public function testPost()
    {
        $guzzleClient = $this->buildGuzzleClient();
        $adapter      = new GuzzleAdapter($guzzleClient);
        $connection   = new Connection('www.google.com');
        $body         = new MemoryStream();
        $actual       = $adapter->post($connection, '/', $body);
        $this->assertInstanceOf('Psr\Http\Message\ResponseInterface', $actual);
    }

    public function testPut()
    {
        $guzzleClient = $this->buildGuzzleClient();
        $adapter      = new GuzzleAdapter($guzzleClient);
        $connection   = new Connection('www.google.com');
        $body         = new MemoryStream();
        $actual       = $adapter->put($connection, '/', $body);
        $this->assertInstanceOf('Psr\Http\Message\ResponseInterface', $actual);
    }

    public function testDelete()
    {
        $guzzleClient = $this->buildGuzzleClient();
        $adapter      = new GuzzleAdapter($guzzleClient);
        $connection   = new Connection('www.google.com');
        $actual       = $adapter->delete($connection, '/');
        $this->assertInstanceOf('Psr\Http\Message\ResponseInterface', $actual);
    }

    public function testPatch()
    {
        $guzzleClient = $this->buildGuzzleClient();
        $adapter      = new GuzzleAdapter($guzzleClient);
        $connection   = new Connection('www.google.com');
        $body         = new MemoryStream();
        $actual       = $adapter->patch($connection, '/', $body);
        $this->assertInstanceOf('Psr\Http\Message\ResponseInterface', $actual);
    }

    private static function buildGuzzleClient()
    {
        return new GuzzleClient([
            'http_errors' => false,
        ]);
    }
}
