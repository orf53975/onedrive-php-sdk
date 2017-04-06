<?php

namespace Krizalys\Onedrive\Facet;

class File
{
    /**
     * @var string
     *      The MIME type.
     */
    private $mimeType;

    /**
     * @var Hashes
     *      The hashes.
     */
    private $hashes;

    /**
     * @var bool
     *      The processing metadata.
     */
    private $processingMetadata;

    /**
     * @param string $mimeType
     *        The MIME type.
     * @param Hashes $hashes
     *        The hashes.
     * @param bool $processingMetadata
     *        The processing metadata.
     */
    public function __construct(
        $mimeType = '',
        Hashes $hashes = null,
        $processingMetadata = false
    ) {
        $this->setMimeType($mimeType);
        $this->setHashes($hashes);
        $this->setProcessingMetadata($processingMetadata);
    }

    /**
     * @param string $mimeType
     *        The MIME type.
     */
    public function setMimeType($mimeType)
    {
        $this->mimeType = (string) $mimeType;
    }

    /**
     * @return string
     *         The MIME type.
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * @param Hashes $hashes
     *        The hashes.
     */
    public function setHashes(Hashes $hashes = null)
    {
        $this->hashes = $hashes;
    }

    /**
     * @return Hashes
     *         The hashes.
     */
    public function getHashes()
    {
        return $this->hashes;
    }

    /**
     * @param bool $processingMetadata
     *        The processing metadata.
     */
    public function setProcessingMetadata($processingMetadata)
    {
        $this->processingMetadata = (bool) $processingMetadata;
    }

    /**
     * @return bool
     *         The processing metadata.
     */
    public function isProcessingMetadata()
    {
        return $this->processingMetadata;
    }
}
