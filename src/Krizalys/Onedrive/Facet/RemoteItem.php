<?php

namespace Krizalys\Onedrive\Facet;

class RemoteItem
{
    /**
     * @var null|IdentitySet
     *      The created by.
     */
    private $createdBy;

    /**
     * @var null|File
     *      The file.
     */
    private $file;

    /**
     * @var null|FileSystemInfo
     *      The file system info.
     */
    private $fileSystemInfo;

    /**
     * @var null|Folder
     *      The folder.
     */
    private $folder;

    /**
     * @var string
     *      The ID.
     */
    private $id;

    /**
     * @var null|IdentitySet
     *      The last modified by.
     */
    private $lastModifiedBy;

    /**
     * @var null|\DateTimeInterface
     *      The last modified date time.
     */
    private $lastModifiedDateTime;

    /**
     * @var string
     *      The name.
     */
    private $name;

    /**
     * @var null|ItemReference
     *      The item reference.
     */
    private $parentReference;

    /**
     * @var null|Shared
     *      The shared.
     */
    private $shared;

    /**
     * @var int
     *      The size, in bytes.
     */
    private $size;

    /**
     * @var null|UriInterface
     *      The web URL.
     */
    private $webUrl;

    /**
     * @param null|IdentitySet $createdBy
     *        The created by.
     * @param null|File $file
     *        The file.
     * @param null|FileSystemInfo $fileSystemInfo
     *        The file system info.
     * @param null|Folder $folder
     *        The folder.
     * @param string $id
     *        The ID.
     * @param null|IdentitySet $lastModifiedBy
     *        The last modified by.
     * @param null|\DateTimeInterface $lastModifiedDateTime
     *        The last modified date time.
     * @param string $name
     *        The name.
     * @param null|ItemReference $parentReference
     *        The item reference.
     * @param null|Shared $shared
     *        The shared.
     * @param int $size
     *        The size, in bytes.
     * @param null|UriInterface $webUrl
     *        The web URL.
     */
    public function __construct(
        IdentitySet $createdBy = null,
        File $file = null,
        FileSystemInfo $fileSystemInfo = null,
        Folder $folder = null,
        $id = '',
        IdentitySet $lastModifiedBy = null,
        \DateTimeInterface $lastModifiedDateTime = null,
        $name = '',
        ItemReference $parentReference = null,
        Shared $shared = null,
        $size = 0,
        UriInterface $webUrl = null
    ) {
        $this->setCreatedBy($createdBy);
        $this->setFile($file);
        $this->setFileSystemInfo($fileSystemInfo);
        $this->setFolder($folder);
        $this->setId($id);
        $this->setLastModifiedBy();
        $this->setLastModifiedDateTime();
        $this->setName($name);
        $this->setParentReference($parentReference);
        $this->setShared($shared);
        $this->setSize($size);
        $this->setWebUrl($webUrl);
    }

    /**
     * @param null|IdentitySet $createdBy
     *        The created by.
     */
    public function setCreatedBy(IdentitySet $createdBy = null)
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @return null|IdentitySet
     *         The created by.
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param null|File $file
     *        The file.
     */
    public function setFile(File $file = null)
    {
        $this->file = $file;
    }

    /**
     * @return null|File
     *         The file.
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param null|FileSystemInfo $fileSystemInfo
     *        The file system info.
     */
    public function setFileSystemInfo(FileSystemInfo $fileSystemInfo = null)
    {
        $this->fileSystemInfo = $fileSystemInfo;
    }

    /**
     * @return null|FileSystemInfo
     *         The file system info.
     */
    public function getFileSystemInfo()
    {
        return $this->fileSystemInfo;
    }

    /**
     * @param null|Folder $folder
     *        The folder.
     */
    public function setFolder(Folder $folder = null)
    {
        $this->folder = $folder;
    }

    /**
     * @return null|Folder
     *         The folder.
     */
    public function getFolder()
    {
        return $this->folder;
    }

    /**
     * @param string $id
     *        The ID.
     */
    public function setId($id)
    {
        $this->id = (string) $id;
    }

    /**
     * @return string
     *         The ID.
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param null|IdentitySet $lastModifiedBy
     *        The last modified by.
     */
    public function setLastModifiedBy(IdentitySet $identitySet = null)
    {
        $this->lastModifiedBy = $identitySet;
    }

    /**
     * @return null|IdentitySet
     *         The last modified by.
     */
    public function getLastModifiedBy()
    {
        return $this->lastModifiedBy;
    }

    /**
     * @param null|\DateTimeInterface $lastModifiedDateTime
     *        The last modified date time.
     */
    public function setLastModifiedDateTime(\DateTimeInterface $lastModifiedDateTime = null)
    {
        $this->lastModifiedDateTime = $lastModifiedDateTime;
    }

    /**
     * @return null|\DateTimeInterface
     *         The last modified date time.
     */
    public function getLastModifiedDateTime()
    {
        return $this->lastModifiedDateTime;
    }

    /**
     * @param string $name
     *        The name.
     */
    public function setName($name)
    {
        $this->name = (string) $name;
    }

    /**
     * @return string
     *         The name.
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param null|ItemReference $parentReference
     *        The item reference.
     */
    public function setParentReference(ItemReference $parentReference = null)
    {
        $this->parentReference = $parentReference;
    }

    /**
     * @return null|ItemReference
     *         The item reference.
     */
    public function getParentReference()
    {
        return $this->parentReference;
    }

    /**
     * @param null|Shared $shared
     *        The shared.
     */
    public function setShared(Shared $shared = null)
    {
        $this->shared = $shared;
    }

    /**
     * @return null|Shared
     *         The shared.
     */
    public function getShared()
    {
        return $this->shared;
    }

    /**
     * @param int $size
     *        The size, in bytes.
     */
    public function setSize($size)
    {
        $this->size = (int) $size;
    }

    /**
     * @return int
     *         The size, in bytes.
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param null|UriInterface $webUrl
     *        The web URL.
     */
    public function setWebUrl(UriInterface $webUrl = null)
    {
        $this->setWebUrl = $webUrl;
    }

    /**
     * @return null|UriInterface
     *         The web URL.
     */
    public function getWebUrl()
    {
        return $this->webUrl;
    }
}
