<?php

namespace Krizalys\Onedrive\Facet;

class Photo
{
    /**
     * @var \DateTimeInterface
     *      The taken date time.
     */
    private $takenDateTime;

    /**
     * @var string
     *      The camera make.
     */
    private $cameraMake;

    /**
     * @var string
     *      The camera model.
     */
    private $cameraModel;

    /**
     * @var float
     *      The F-stop number.
     */
    private $fNumber;

    /**
     * @var float
     *      The exposure denominator.
     */
    private $exposureDenominator;

    /**
     * @var float
     *      The exposure numerator.
     */
    private $exposureNumerator;

    /**
     * @var float
     *      The focal length.
     */
    private $focalLength;

    /**
     * @var int
     *      The ISO value.
     */
    private $iso;

    /**
     * @param \DateTimeInterface $takenDateTime
     *        The taken date time.
     * @param string $cameraMake
     *        The camera make.
     * @param string $cameraModel
     *        The camera model.
     * @param float $fNumber
     *        The F-stop number.
     * @param float $exposureDenominator
     *        The exposure denominator.
     * @param float $exposureNumerator
     *        The exposure numerator.
     * @param float $focalLength
     *        The focal length.
     * @param int $iso
     *        The ISO value.
     */
    public function __construct(
        \DateTimeInterface $takenDateTime = null,
        $cameraMake = '',
        $cameraModel = '',
        $fNumber = 0.0,
        $exposureDenominator = 0.0,
        $exposureNumerator = 0.0,
        $focalLength = 0.0,
        $iso = 0
    ) {
        $this->setTakenDateTime($takenDateTime);
        $this->setCameraMake($cameraMake);
        $this->setCameraModel($cameraModel);
        $this->setFNumber($fNumber);
        $this->setExposureDenominator($exposureDenominator);
        $this->setExposureNumerator($exposureNumerator);
        $this->setFocalLength($focalLength);
        $this->setIso($iso);
    }

    /**
     * @param \DateTimeInterface $takenDateTime
     *        The taken date time.
     */
    public function setTakenDateTime(\DateTimeInterface $takenDateTime = null)
    {
        $this->takenDateTime = $takenDateTime;
    }

    /**
     * @return \DateTimeInterface
     *         The taken date time.
     */
    public function getTakenDateTime()
    {
        return $this->takenDateTime;
    }

    /**
     * @param string $cameraMake
     *        The camera make.
     */
    public function setCameraMake($cameraMake)
    {
        $this->cameraMake = (string) $cameraMake;
    }

    /**
     * @return string
     *         The camera make.
     */
    public function getCameraMake()
    {
        return $this->cameraMake;
    }

    /**
     * @param string $cameraModel
     *        The camera model.
     */
    public function setCameraModel($cameraModel)
    {
        $this->cameraModel = (string) $cameraModel;
    }

    /**
     * @return string
     *         The camera model.
     */
    public function getCameraModel()
    {
        return $this->cameraModel;
    }

    /**
     * @param float $fNumber
     *        The F-stop number.
     */
    public function setFNumber($fNumber)
    {
        $this->fNumber = (float) $fNumber;
    }

    /**
     * @return float
     *         The F-stop number.
     */
    public function getFNumber()
    {
        return $this->fNumber;
    }

    /**
     * @param float $exposureDenominator
     *        The exposure denominator.
     */
    public function setExposureDenominator($exposureDenominator)
    {
        $this->exposureDenominator = (float) $exposureDenominator;
    }

    /**
     * @return float
     *         The exposure denominator.
     */
    public function getExposureDenominator()
    {
        return $this->exposureDenominator;
    }

    /**
     * @param float $exposureNumerator
     *        The exposure numerator.
     */
    public function setExposureNumerator($exposureNumerator)
    {
        $this->exposureNumerator = (float) $exposureNumerator;
    }

    /**
     * @return float
     *         The exposure numerator.
     */
    public function getExposureNumerator()
    {
        return $this->exposureNumerator;
    }

    /**
     * @param float $focalLength
     *        The focal length.
     */
    public function setFocalLength($focalLength)
    {
        $this->focalLength = (float) $focalLength;
    }

    /**
     * @return float
     *         The focal length.
     */
    public function getFocalLength()
    {
        return $this->focalLength;
    }

    /**
     * @param int $iso
     *        The ISO value.
     */
    public function setIso($iso)
    {
        $this->iso = (int) $iso;
    }

    /**
     * @return int
     *         The ISO value.
     */
    public function getIso()
    {
        return $this->iso;
    }
}
