<?php

namespace Krizalys\Onedrive\Facet\Factory;

use Krizalys\Onedrive\Facet\SearchResult;

class SearchResultFactory
{
    /**
     * @var array
     *      The mappings.
     */
    private static $mappings = [
        'onClickTelemetryUrl' => 'onClickTelemetryUrl',
    ];

    /**
     * @param object $properties
     *        The properties.
     *
     * @return SearchResult
     *         The search result.
     */
    public function createFromProperties($properties)
    {
        $searchResult = new SearchResult();

        foreach (static::$mappings as $property => $setterSuffix) {
            if (property_exists($properties, $property)) {
                $setter = 'set' . ucfirst($setterSuffix);
                call_user_func([$searchResult, $setter], $properties->{$property});
            }
        }

        return $searchResult;
    }
}
