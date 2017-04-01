<?php

namespace Test\Unit\Krizalys\Onedrive\Http;

use Krizalys\Onedrive\Http\Uri;

class UriTest extends \PHPUnit_Framework_TestCase
{
    public function provideGetAuthorityShouldReturnExpectedValue()
    {
        return [
            [
                'build' => function () {
                    return new Uri();
                },
                'expected' => '',
            ],
            [
                'build' => function () {
                    $sut = new Uri();
                    return $sut->withHost('ho.st');
                },
                'expected' => 'ho.st',
            ],
            [
                'build' => function () {
                    $sut = new Uri();

                    return $sut
                        ->withHost('ho.st')
                        ->withPort('1234');
                },
                'expected' => 'ho.st:1234',
            ],
            [
                'build' => function () {
                    $sut = new Uri();

                    return $sut
                        ->withHost('ho.st')
                        ->withUserInfo('user');
                },
                'expected' => 'user@ho.st',
            ],
            [
                'build' => function () {
                    $sut = new Uri();

                    return $sut
                        ->withHost('ho.st')
                        ->withUserInfo('user', null);
                },
                'expected' => 'user@ho.st',
            ],
            [
                'build' => function () {
                    $sut = new Uri();

                    return $sut
                        ->withHost('ho.st')
                        ->withUserInfo('user', 'XXX');
                },
                'expected' => 'user:XXX@ho.st',
            ],
            [
                'build' => function () {
                    $sut = new Uri();

                    return $sut
                        ->withHost('ho.st')
                        ->withPort('1234')
                        ->withUserInfo('user');
                },
                'expected' => 'user@ho.st:1234',
            ],
            [
                'build' => function () {
                    $sut = new Uri();

                    return $sut
                        ->withHost('ho.st')
                        ->withPort('1234')
                        ->withUserInfo('user', null);
                },
                'expected' => 'user@ho.st:1234',
            ],
            [
                'build' => function () {
                    $sut = new Uri();

                    return $sut
                        ->withHost('ho.st')
                        ->withPort('1234')
                        ->withUserInfo('user', 'XXX');
                },
                'expected' => 'user:XXX@ho.st:1234',
            ],
        ];
    }

    /**
     * @dataProvider provideGetAuthorityShouldReturnExpectedValue
     */
    public function testGetAuthorityShouldReturnExpectedValue($build, $expected)
    {
        $sut    = $build();
        $actual = $sut->getAuthority();
        $this->assertSame($expected, $actual);
    }

    public function provideGetUserInfoShouldReturnExpectedValue()
    {
        return [
            [
                'build' => function () {
                    return new Uri();
                },
                'expected' => '',
            ],
            [
                'build' => function () {
                    $sut = new Uri();
                    return $sut->withUserInfo('user');
                },
                'expected' => 'user',
            ],
            [
                'build' => function () {
                    $sut = new Uri();
                    return $sut->withUserInfo('user', null);
                },
                'expected' => 'user',
            ],
            [
                'build' => function () {
                    $sut = new Uri();
                    return $sut->withUserInfo('user', 'XXX');
                },
                'expected' => 'user:XXX',
            ],
        ];
    }

    /**
     * @dataProvider provideGetUserInfoShouldReturnExpectedValue
     */
    public function testGetUserInfoShouldReturnExpectedValue($build, $expected)
    {
        $sut    = $build();
        $actual = $sut->getUserInfo();
        $this->assertSame($expected, $actual);
    }

    public function testWithSchemeShouldReturnExpectedValue()
    {
        $sut    = new Uri();
        $sut    = $sut->withScheme('scheme');
        $actual = $sut->getScheme();
        $this->assertSame('scheme', $actual);
    }

    public function provideWithUserInfoShouldReturnExpectedValue()
    {
        return [
            [
                'arguments' => ['user'],
                'expected'  => 'user',
            ],
            [
                'arguments' => ['user', null],
                'expected'  => 'user',
            ],
            [
                'arguments' => ['user', 'XXX'],
                'expected'  => 'user:XXX',
            ],
        ];
    }

    /**
     * @dataProvider provideWithUserInfoShouldReturnExpectedValue
     */
    public function testWithUserInfoShouldReturnExpectedValue($arguments, $expected)
    {
        $sut    = new Uri();
        $sut    = call_user_func_array([$sut, 'withUserInfo'], $arguments);
        $actual = $sut->getUserInfo();
        $this->assertSame($expected, $actual);
    }

    public function testWithHostShouldReturnExpectedValue()
    {
        $sut    = new Uri();
        $sut    = $sut->withHost('ho.st');
        $actual = $sut->getHost();
        $this->assertSame('ho.st', $actual);
    }

    public function testWithPortShouldReturnExpectedValue()
    {
        $sut    = new Uri();
        $sut    = $sut->withHost('ho.st');
        $actual = $sut->getHost();
        $this->assertSame('ho.st', $actual);
    }

    public function testWithPathShouldReturnExpectedValue()
    {
        $sut    = new Uri();
        $sut    = $sut->withPort('1234');
        $actual = $sut->getPort();
        $this->assertSame(1234, $actual);
    }

    public function testWithQueryShouldReturnExpectedValue()
    {
        $sut    = new Uri();
        $sut    = $sut->withQuery('query');
        $actual = $sut->getQuery();
        $this->assertSame('query', $actual);
    }

    public function testWithFragmenthouldReturnExpectedValue()
    {
        $sut    = new Uri();
        $sut    = $sut->withFragment('fragment');
        $actual = $sut->getFragment();
        $this->assertSame('fragment', $actual);
    }

    public function provideToStringShouldReturnTheExpectedValue()
    {
        return [
            [
                function () {
                    return new Uri();
                },
                '',
            ],
            [
                function () {
                    $sut = new Uri();
                    return $sut->withScheme('scheme');
                },
                '',
            ],
            [
                function () {
                    $sut = new Uri();
                    return $sut->withHost('ho.st');
                },
                '',
            ],
            [
                function () {
                    $sut = new Uri();

                    return $sut
                        ->withScheme('scheme')
                        ->withHost('ho.st');
                },
                'scheme://ho.st',
            ],
            [
                function () {
                    $sut = new Uri();

                    return $sut
                        ->withScheme('scheme')
                        ->withHost('ho.st')
                        ->withPort('1234');
                },
                'scheme://ho.st:1234',
            ],
            [
                function () {
                    $sut = new Uri();

                    return $sut
                        ->withScheme('scheme')
                        ->withHost('ho.st')
                        ->withPath('/path');
                },
                'scheme://ho.st/path',
            ],
            [
                function () {
                    $sut = new Uri();

                    return $sut
                        ->withScheme('scheme')
                        ->withHost('ho.st')
                        ->withQuery('query=string');
                },
                'scheme://ho.st?query=string',
            ],
            [
                function () {
                    $sut = new Uri();

                    return $sut
                        ->withScheme('scheme')
                        ->withHost('ho.st')
                        ->withFragment('fragment');
                },
                'scheme://ho.st#fragment',
            ],
            [
                function () {
                    $sut = new Uri();

                    return $sut
                        ->withScheme('scheme')
                        ->withUserInfo('user', 'XXX')
                        ->withHost('ho.st')
                        ->withPort('1234')
                        ->withPath('/path')
                        ->withQuery('query=string')
                        ->withFragment('fragment');
                },
                'scheme://user:XXX@ho.st:1234/path?query=string#fragment',
            ],
        ];
    }

    /**
     * @dataProvider provideToStringShouldReturnTheExpectedValue
     */
    public function testToStringShouldReturnTheExpectedValue($build, $expected)
    {
        $sut    = $build();
        $actual = $sut->__toString();
        $this->assertSame($expected, $actual);
    }
}
