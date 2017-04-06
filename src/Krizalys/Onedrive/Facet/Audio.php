<?php

namespace Krizalys\Onedrive\Facet;

class Audio
{
    /**
     * @var string
     *      The album.
     */
    private $album;

    /**
     * @var string
     *      The album artist.
     */
    private $albumArtist;

    /**
     * @var string
     *      The artist.
     */
    private $artist;

    /**
     * @var int
     *      The bitrate, in kbps.
     */
    private $bitrate;

    /**
     * @var string
     *      The composers.
     */
    private $composers;

    /**
     * @var string
     *      The copyright.
     */
    private $copyright;

    /**
     * @var int
     *      The disc.
     */
    private $disc;

    /**
     * @var int
     *      The disc count.
     */
    private $discCount;

    /**
     * @var int
     *      The duration, in milliseconds.
     */
    private $duration;

    /**
     * @var string
     *      The genre.
     */
    private $genre;

    /**
     * @var bool
     *      The DRM flag.
     */
    private $hasDrm;

    /**
     * @var bool
     *      The variable bitrate flag.
     */
    private $isVariableBitrate;

    /**
     * @var string
     *      The title.
     */
    private $title;

    /**
     * @var int
     *      The track.
     */
    private $track;

    /**
     * @var int
     *      The track count.
     */
    private $trackCount;

    /**
     * @var int
     *      The year.
     */
    private $year;

    /**
     * @param string $album
     *        The album.
     * @param string $albumArtist
     *        The album artist.
     * @param string $artist
     *        The artist.
     * @param int $bitrate
     *        The bitrate, in kbps.
     * @param string $composers
     *        The composers.
     * @param string $copyright
     *        The copyright.
     * @param int $disc
     *        The disc.
     * @param int $discCount
     *        The disc count.
     * @param int $duration
     *        The duration, in milliseconds.
     * @param string $genre
     *        The genre.
     * @param bool $hasDrm
     *        The DRM flag.
     * @param bool $isVariableBitrate
     *        The variable bitrate flag.
     * @param string $title
     *        The title.
     * @param int $track
     *        The track.
     * @param int $trackCount
     *        The track count.
     * @param int $year
     *        The year.
     */
    public function __construct(
        $album = '',
        $albumArtist = '',
        $artist = '',
        $bitrate = 0,
        $composers = '',
        $copyright = '',
        $disc = 0,
        $discCount = 0,
        $duration = 0,
        $genre = '',
        $hasDrm = false,
        $isVariableBitrate = false,
        $title = '',
        $track = 0,
        $trackCount = 0,
        $year = 0
    ) {
        $this->setAlbum($album);
        $this->setAlbumArtist($albumArtist);
        $this->setArtist($artist);
        $this->setBitrate($bitrate);
        $this->setComposers($composers);
        $this->setCopyright($copyright);
        $this->setDisc($disc);
        $this->setDiscCount($discCount);
        $this->setDuration($duration);
        $this->setGenre($genre);
        $this->setHasDrm($hasDrm);
        $this->setVariableBitRate($isVariableBitrate);
        $this->setTitle($title);
        $this->setTrack($track);
        $this->setTrackCount($trackCount);
        $this->setYear($year);
    }

    /**
     * @param string $album
     *        The album.
     */
    public function setAlbum($album) {
        $this->album = (string) $album;
    }

    /**
     * @return string
     *         The album.
     */
    public function getAlbum() {
        return $this->album;
    }

    /**
     * @param string $albumArtist
     *        The album artist.
     */
    public function setAlbumArtist($albumArtist) {
        $this->albumArtist = (string) $albumArtist;
    }

    /**
     * @return string
     *         The album artist.
     */
    public function getAlbumArtist() {
        return $this->albumArtist;
    }

    /**
     * @param string $artist
     *        The artist.
     */
    public function setArtist($artist) {
        $this->artist = (string) $artist;
    }

    /**
     * @return string
     *         The artist.
     */
    public function getArtist() {
        return $this->artist;
    }

    /**
     * @param int $bitrate
     *        The bitrate, in kbps.
     */
    public function setBitrate($bitrate) {
        $this->bitrate = (int) $bitrate;
    }

    /**
     * @return int
     *         The bitrate, in kbps.
     */
    public function getBitrate() {
        return $this->bitrate;
    }

    /**
     * @param string $composers
     *        The composers.
     */
    public function setComposers($composers) {
        $this->composers = (string) $composers;
    }

    /**
     * @return string
     *         The composers.
     */
    public function getComposers() {
        return $this->composers;
    }

    /**
     * @param string $copyright
     *        The copyright.
     */
    public function setCopyright($copyright) {
        $this->copyright = (string) $copyright;
    }

    /**
     * @return string
     *         The copyright.
     */
    public function getCopyright() {
        return $this->copyright;
    }

    /**
     * @param int $disc
     *        The disc.
     */
    public function setDisc($disc) {
        $this->disc = (int) $disc;
    }

    /**
     * @return int
     *         The disc.
     */
    public function getDisc() {
        return $this->disc;
    }

    /**
     * @param int $discCount
     *        The disc count.
     */
    public function setDiscCount($discCount) {
        $this->discCount = (int) $discCount;
    }

    /**
     * @return int
     *         The disc count.
     */
    public function getDiscCount() {
        return $this->discCount;
    }

    /**
     * @param int $duration
     *        The duration, in milliseconds.
     */
    public function setDuration($duration) {
        $this->duration = (int) $duration;
    }

    /**
     * @return int
     *         The duration, in milliseconds.
     */
    public function getDuration() {
        return $this->duration;
    }

    /**
     * @param string $genre
     *        The genre.
     */
    public function setGenre($genre) {
        $this->genre = (string) $genre;
    }

    /**
     * @return string
     *         The genre.
     */
    public function getGenre() {
        return $this->genre;
    }

    /**
     * @param bool $hasDrm
     *        The DRM flag.
     */
    public function setHasDrm($hasDrm) {
        $this->hasDrm = (bool) $hasDrm;
    }

    /**
     * @return bool
     *         The DRM flag.
     */
    public function hasDrm() {
        return $this->hasDrm;
    }

    /**
     * @param bool $isVariableBitrate
     *        The variable bitrate flag.
     */
    public function setVariableBitRate($isVariableBitrate) {
        $this->isVariableBitrate = (bool) $isVariableBitrate;
    }

    /**
     * @return bool
     *         The variable bitrate flag.
     */
    public function isVariableBitRate() {
        return $this->isVariableBitrate;
    }

    /**
     * @param string $title
     *        The title.
     */
    public function setTitle($title) {
        $this->title = (string) $title;
    }

    /**
     * @return string
     *         The title.
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * @param int $track
     *        The track.
     */
    public function setTrack($track) {
        $this->track = (int) $track;
    }

    /**
     * @return int
     *         The track.
     */
    public function getTrack() {
        return $this->track;
    }

    /**
     * @param int $trackCount
     *        The track count.
     */
    public function setTrackCount($trackCount) {
        $this->trackCount = (int) $trackCount;
    }

    /**
     * @return int
     *         The track count.
     */
    public function getTrackCount() {
        return $this->trackCount;
    }

    /**
     * @param int $year
     *        The year.
     */
    public function setYear($year) {
        $this->year = (int) $year;
    }

    /**
     * @return int
     *         The year.
     */
    public function getYear() {
        return $this->year;
    }
}
