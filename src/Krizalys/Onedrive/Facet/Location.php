<?php

namespace Krizalys\Onedrive\Facet;

class Location
{
    /**
     * @var float
     *      The altitude, in feet above sea level.
     */
    private $altitude;

    /**
     * @var float
     *      The latitude, in degrees.
     */
    private $latitude;

    /**
     * @var float
     *      The longitude, in degrees.
     */
    private $longitude;

    /**
     * @param float $altitude
     *        The altitude, in feet above sea level.
     * @param float $latitude
     *        The latitude, in degrees.
     * @param float $longitude
     *        The longitude, in degrees.
     */
    public function __construct(
        $altitude = 0.0,
        $latitude = 0.0,
        $longitude = 0.0
    ) {
        $this->setAltitude($altitude);
        $this->setLatitude($latitude);
        $this->setLongitude($longitude);
    }

    /**
     * @param float $altitude
     *        The altitude, in feet above sea level.
     */
    public function setAltitude($altitude)
    {
        $this->altitude = (float) $altitude;
    }

    /**
     * @return float
     *         The altitude, in feet above sea level.
     */
    public function getAltitude()
    {
        return $this->altitude;
    }

    /**
     * @param float $latitude
     *        The latitude, in degrees.
     */
    public function setLatitude($latitude)
    {
        $this->latitude = (float) $latitude;
    }

    /**
     * @return float
     *         The latitude, in degrees.
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param float $longitude
     *        The longitude, in degrees.
     */
    public function setLongitude($longitude)
    {
        $this->longitude = (float) $longitude;
    }

    /**
     * @return float
     *         The longitude, in degrees.
     */
    public function getLongitude()
    {
        return $this->longitude;
    }
}
