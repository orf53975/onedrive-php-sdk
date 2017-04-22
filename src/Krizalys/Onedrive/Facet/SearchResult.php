<?php

namespace Krizalys\Onedrive\Facet;

class SearchResult
{
    /**
     * @var null|UriInterface
     *      The onClick telemetry URL.
     */
    private $onClickTelemetryUrl;

    /**
     * @param null|UriInterface $onClickTelemetryUrl
     *        The onClick telemetry URL.
     */
    public function __construct(UriInterface $onClickTelemetryUrl = null)
    {
        $this->setOnClickTelemetryUrl($onClickTelemetryUrl);
    }

    /**
     * @param null|UriInterface $onClickTelemetryUrl
     *        The onClick telemetry URL.
     */
    public function setOnClickTelemetryUrl(UriInterface $onClickTelemetryUrl = null)
    {
        $this->onClickTelemetryUrl = $onClickTelemetryUrl;
    }

    /**
     * @return null|UriInterface
     *         The onClick telemetry URL.
     */
    public function getOnClickTelemetryUrl()
    {
        return $this->onClickTelemetryUrl;
    }
}
