<?php

namespace Krizalys\Onedrive\Facet;

class Hashes
{
    /**
     * @var string
     *      The CRC32 hash, in hexadecimal.
     */
    private $crc32Hash;

    /**
     * @var string
     *      The SHA1 hash, in hexadecimal.
     */
    private $sha1Hash;

    /**
     * @var string
     *      The quick XOR hash, in base64.
     */
    private $quickXorHash;

    /**
     * @param string $crc32Hash
     *        The CRC32 hash, in hexadecimal.
     * @param string $sha1Hash
     *        The SHA1 hash, in hexadecimal.
     * @param string $quickXorHash
     *        The quick XOR hash, in base64.
     */
    public function __construct(
        $crc32Hash = '',
        $sha1Hash = '',
        $quickXorHash = ''
    ) {
        $this->setCrc32Hash($crc32Hash);
        $this->setSha1Hash($sha1Hash);
        $this->setQuickXorHash($quickXorHash);
    }

    /**
     * @param string $crc32Hash
     *        The CRC32 hash, in hexadecimal.
     */
    public function setCrc32Hash($crc32Hash)
    {
        $this->crc32Hash = (string) $crc32Hash;
    }

    /**
     * @return string
     *         The CRC32 hash, in hexadecimal.
     */
    public function getCrc32Hash()
    {
        return $this->crc32Hash;
    }

    /**
     * @param string $sha1Hash
     *        The SHA1 hash, in hexadecimal.
     */
    public function setSha1Hash($sha1Hash)
    {
        $this->sha1Hash = (string) $sha1Hash;
    }

    /**
     * @return string
     *         The SHA1 hash, in hexadecimal.
     */
    public function getSha1Hash()
    {
        return $this->sha1Hash;
    }

    /**
     * @param string $quickXorHash
     *        The quick XOR hash, in base64.
     */
    public function setQuickXorHash($quickXorHash)
    {
        $this->quickXorHash = (string) $quickXorHash;
    }

    /**
     * @return string
     *         The quick XOR hash, in base64.
     */
    public function getQuickXorHash()
    {
        return $this->quickXorHash;
    }
}
