<?php

namespace Test\Unit\Krizalys\Onedrive\Http;

use Krizalys\Onedrive\Http\Connection;
use Krizalys\Onedrive\Http\UriCanonicalizer;

class UriCanonicalizerTest extends \PHPUnit_Framework_TestCase
{
    public function provideCanonicalizeShouldReturnExpectedValue()
    {
        return [
            [
                new Connection('ho.st', 80, false),
                'http://ho.st/path?query=string#fragment',
            ],
            [
                new Connection('ho.st', 80, true),
                'https://ho.st:80/path?query=string#fragment',
            ],
            [
                new Connection('ho.st', 443, false),
                'http://ho.st:443/path?query=string#fragment',
            ],
            [
                new Connection('ho.st', 443, true),
                'https://ho.st/path?query=string#fragment',
            ],
            [
                new Connection('ho.st', 1234, false),
                'http://ho.st:1234/path?query=string#fragment',
            ],
            [
                new Connection('ho.st', 1234, true),
                'https://ho.st:1234/path?query=string#fragment',
            ],
        ];
    }

    /**
     * @dataProvider provideCanonicalizeShouldReturnExpectedValue
     */
    public function testCanonicalizeShouldReturnExpectedValue($connection, $expected)
    {
        $sut    = new UriCanonicalizer();
        $actual = $sut->canonicalize($connection, '/path', 'query=string', 'fragment');
        $this->assertInstanceOf('Psr\Http\Message\UriInterface', $actual);
        $actual = (string) $actual;
        $this->assertSame($expected, $actual);
    }
}
