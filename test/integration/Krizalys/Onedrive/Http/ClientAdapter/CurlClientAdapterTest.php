<?php

namespace Test\Krizalys\Onedrive\Http\ClientAdapter;

use Krizalys\Onedrive\Http\ClientAdapter\CurlClientAdapter;
use Krizalys\Onedrive\Http\Request\Request;
use Krizalys\Onedrive\Http\Resource\Resource;
use Krizalys\Onedrive\Http\Resource\StreamResource;
use Krizalys\Onedrive\Http\Resource\ValuesResource;

class CurlClientAdapterTest extends \PHPUnit_Framework_TestCase
{
    /**
     * This test expects http://www.google.com/test/path to produce an HTTP 404
     * Not Found response with a text/html; charset=UTF-8 body when requested
     * using the TEST method.
     */
    public function testSendShouldReturnTheExpectedValueWithCustomMethod()
    {
        $client  = $this->buildClient();
        $body    = new Resource('Irrelevant', 'text/plain');
        $request = new Request('TEST', '/test/path', array('Test-Header: Test value'), $body);
        $actual  = $client->send('www.google.com', $request);
        $this->assertInstanceOf('Krizalys\Onedrive\Http\Response\ResponseInterface', $actual);
        $this->assertSame(404, $actual->getStatusCode());
        $this->assertSame('', $actual->getStatusReason());
        $this->assertSame(array(), $actual->getHeaders());
        $actualBody = $actual->getBody();
        $this->assertInstanceOf('Krizalys\Onedrive\Http\Resource\ResourceInterface', $actualBody);
        $this->assertSame('text/html; charset=UTF-8', $actualBody->getContentType());
    }

    /**
     * This test expects http://www.google.com/test/path to produce an HTTP 404
     * Not Found response with a text/html; charset=UTF-8 body when requested
     * using the GET method.
     */
    public function testSendShouldReturnTheExpectedValueWithGet()
    {
        $client  = $this->buildClient();
        $body    = new Resource('Irrelevant', 'text/plain');
        $request = new Request('GET', '/test/path', array('Test-Header: Test value'), $body);
        $actual  = $client->send('www.google.com', $request);
        $this->assertInstanceOf('Krizalys\Onedrive\Http\Response\ResponseInterface', $actual);
        $this->assertSame(404, $actual->getStatusCode());
        $this->assertSame('', $actual->getStatusReason());
        $this->assertSame(array(), $actual->getHeaders());
        $actualBody = $actual->getBody();
        $this->assertInstanceOf('Krizalys\Onedrive\Http\Resource\ResourceInterface', $actualBody);
        $this->assertSame('text/html; charset=UTF-8', $actualBody->getContentType());
    }

    /**
     * This test expects http://www.google.com/test/path to produce an HTTP 404
     * Not Found response with a text/html; charset=UTF-8 body when requested
     * using the POST method.
     */
    public function testSendShouldReturnTheExpectedValueWithPost()
    {
        $client  = $this->buildClient();
        $body    = new ValuesResource(array('test-field' => 'Test value'));
        $request = new Request('POST', '/test/path', array('Test-Header: Test value'), $body);
        $client  = new CurlClientAdapter();
        $actual  = $client->send('www.google.com', $request);
        $this->assertInstanceOf('Krizalys\Onedrive\Http\Response\ResponseInterface', $actual);
        $this->assertSame(404, $actual->getStatusCode());
        $this->assertSame('', $actual->getStatusReason());
        $this->assertSame(array(), $actual->getHeaders());
        $actualBody = $actual->getBody();
        $this->assertInstanceOf('Krizalys\Onedrive\Http\Resource\ResourceInterface', $actualBody);
        $this->assertSame('text/html; charset=UTF-8', $actualBody->getContentType());
    }

    /**
     * This test expects http://www.google.com/test/path to produce an HTTP 404
     * Not Found response with a text/html; charset=UTF-8 body when requested
     * using the PUT method.
     */
    public function testSendShouldReturnTheExpectedValueWithPut()
    {
        $client = $this->buildClient();
        $stream = fopen('php://memory', 'rw+b');
        fwrite($stream, 'Irrelevant');
        rewind($stream);
        $body    = new StreamResource($stream, 'text/plain');
        $request = new Request('PUT', '/test/path', array('Test-Header: Test value'), $body);
        $actual  = $client->send('www.google.com', $request);
        $this->assertInstanceOf('Krizalys\Onedrive\Http\Response\ResponseInterface', $actual);
        $this->assertSame(404, $actual->getStatusCode());
        $this->assertSame('', $actual->getStatusReason());
        $this->assertSame(array(), $actual->getHeaders());
        $actualBody = $actual->getBody();
        $this->assertInstanceOf('Krizalys\Onedrive\Http\Resource\ResourceInterface', $actualBody);
        $this->assertSame('text/html; charset=UTF-8', $actualBody->getContentType());
    }

    /**
     * This test expects http://www.google.com/test/path to produce an HTTP 404
     * Not Found response with a text/html; charset=UTF-8 body when requested
     * using the DELETE method.
     */
    public function testSendShouldReturnTheExpectedValueWithDelete()
    {
        $client  = $this->buildClient();
        $body    = new Resource('Irrelevant', 'text/plain');
        $request = new Request('DELETE', '/test/path', array('Test-Header: Test value'), $body);
        $actual  = $client->send('www.google.com', $request);
        $this->assertInstanceOf('Krizalys\Onedrive\Http\Response\ResponseInterface', $actual);
        $this->assertSame(404, $actual->getStatusCode());
        $this->assertSame('', $actual->getStatusReason());
        $this->assertSame(array(), $actual->getHeaders());
        $actualBody = $actual->getBody();
        $this->assertInstanceOf('Krizalys\Onedrive\Http\Resource\ResourceInterface', $actualBody);
        $this->assertSame('text/html; charset=UTF-8', $actualBody->getContentType());
    }

    /**
     * This test expects http://www.google.com/test/path to produce an HTTP 404
     * Not Found response with a text/html; charset=UTF-8 body when requested
     * using the PATCH method.
     */
    public function testSendShouldReturnTheExpectedValueWithPatch()
    {
        $client  = $this->buildClient();
        $body    = new Resource('Irrelevant', 'text/plain');
        $request = new Request('PATCH', '/test/path', array('Test-Header: Test value'), $body);
        $actual  = $client->send('www.google.com', $request);
        $this->assertInstanceOf('Krizalys\Onedrive\Http\Response\ResponseInterface', $actual);
        $this->assertSame(404, $actual->getStatusCode());
        $this->assertSame('', $actual->getStatusReason());
        $this->assertSame(array(), $actual->getHeaders());
        $actualBody = $actual->getBody();
        $this->assertInstanceOf('Krizalys\Onedrive\Http\Resource\ResourceInterface', $actualBody);
        $this->assertSame('text/html; charset=UTF-8', $actualBody->getContentType());
    }

    private function buildClient()
    {
        return new CurlClientAdapter(array(
            //CURLOPT_VERBOSE => true,
        ));
    }
}
