<?php

namespace Test\Krizalys\Onedrive\Http\Response;

use Krizalys\Onedrive\Http\Response\ResponseBuilder;
use Krizalys\Onedrive\Http\Resource\Resource;

class ResponseBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testSettersBuildShouldReturnTheExpectedValue()
    {
        $body    = new Resource('Irrelevant', 'text/plain');
        $builder = new ResponseBuilder();

        $actual = $builder
            ->reset()
            ->setStatus('123', 'Test Reason')
            ->addHeader('Test-Header: Test value')
            ->setBody($body)
            ->build();

        $this->assertInstanceOf('Krizalys\Onedrive\Http\Response\ResponseInterface', $actual);
        $this->assertSame(123, $actual->getStatusCode());
        $this->assertSame('Test Reason', $actual->getStatusReason());
        $this->assertSame(array('Test-Header: Test value'), $actual->getHeaders());
        $actualBody = $actual->getBody();
        $this->assertInstanceOf('Krizalys\Onedrive\Http\Resource\ResourceInterface', $actualBody);
        $this->assertSame($body, $actualBody);
    }
}
