<?php

namespace Test\Integration\Krizalys\Onedrive\Facet\Factory;

use Krizalys\Onedrive\Facet\Factory\SearchResultFactory;

class SearchResultFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateFromProperties()
    {
        $searchResultFactory = new SearchResultFactory();

        $searchResult= $searchResultFactory->createFromProperties((object) [
            'onClickTelemetryUrl' => 'http://te.st',
        ]);

        $this->assertInstanceOf('Krizalys\Onedrive\Facet\SearchResult', $searchResult);
        $this->assertSame('http://te.st', $searchResult->getOnClickTelemetryUrl());
    }
}
