<?php

namespace Krizalys\Onedrive\Resource;

class DriveItem
{
    const CONFLICT_BEHAVIOR_FAIL    = 'fail';
    const CONFLICT_BEHAVIOR_REPLACE = 'replace';
    const CONFLICT_BEHAVIOR_RENAME  = 'rename';

    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $eTag;

    /**
     * @var string
     */
    private $cTag;

    /**
     * @var null|IdentitySet
     */
    private $createdBy;

    /**
     * @var null|\DateTimeInterface
     */
    private $createdDateTime;

    /**
     * @var null|IdentitySet
     */
    private $lastModifiedBy;

    /**
     * @var null|\DateTimeInterface
     */
    private $lastModifiedDateTime;

    /**
     * @var int
     */
    private $size;

    /**
     * @var null|UriInterface
     */
    private $webUrl;

    /**
     * @var null|UriInterface
     */
    private $webDavUrl;

    /**
     * @var string
     */
    private $description;

    /**
     * @var null|ItemReference
     */
    private $parentReference;

    /**
     * @var null|Folder
     */
    private $folder;

    /**
     * @var null|File
     */
    private $file;

    /**
     * @var null|FileSystemInfo
     */
    private $fileSystemInfo;

    /**
     * @var null|Image
     */
    private $image;

    /**
     * @var null|Photo
     */
    private $photo;

    /**
     * @var null|Audio
     */
    private $audio;

    /**
     * @var null|Video
     */
    private $video;

    /**
     * @var null|Location
     */
    private $location;

    /**
     * @var null|RemoteItem
     */
    private $remoteItem;

    /**
     * @var null|SearchResult
     */
    private $searchResult;

    /**
     * @var null|Deleted
     */
    private $deleted;

    /**
     * @var null|SpecialFolder
     */
    private $specialFolder;

    /**
     * @var null|Shared
     */
    private $shared;

    /**
     * @var null|SharepointIds
     */
    private $sharepointIds;

    /**
     * @var null|Root
     */
    private $root;

    /**
     * @var array
     */
    private $children;

    /**
     * @var null|ThumbnailSet
     */
    private $thumbnails;

    /**
     * @var string
     */
    private $conflictBehavior;

    /**
     * @var null|UriInterface
     */
    private $downloadUrl;

    /**
     * @var null|UriInterface
     */
    private $sourceUrl;

    /**
     * @var resource
     */
    private $content;

    public function __construct(
        $id = '',
        $name = '',
        $eTag = '',
        $cTag = '',
        IdentitySet $createdBy = null,
        \DateTimeInterface $createdDateTime = null,
        IdentitySet $lastModifiedBy = null,
        \DateTimeInterface $lastModifiedDateTime = null,
        $size = 0,
        UriInterface $webUrl = null,
        UriInterface $webDavUrl = null,
        $description = '',
        ItemReference $parentReference = null,
        Folder $folder = null,
        File $file = null,
        FileSystemInfo $fileSystemInfo = null,
        Image $image = null,
        Photo $photo = null,
        Audio $audio = null,
        Video $video = null,
        Location $location = null,
        RemoteItem $remoteItem = null,
        SearchResult $searchResult = null,
        Deleted $deleted = null,
        SpecialFolder $specialFolder = null,
        Shared $shared = null,
        SharepointIds $sharepointIds = null,
        Root $root = null,
        array $children = [],
        ThumbnailSet $thumbnails = null,
        $conflictBehavior = '',
        UriInterface $downloadUrl = null,
        UriInterface $sourceUrl = null,
        resource $content = null
    ) {
        $this->setId($id);
        $this->setName($name);
    }

    public function setId($id)
    {
        $this->id = (string) $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = (string) $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setEtag($eTag)
    {
        $this->eTag = (string) $eTag;
    }

    public function getEtag()
    {
        return $this->eTag;
    }

    public function setCtag($cTag)
    {
        $this->cTag = (string) $cTag;
    }

    public function getCtag()
    {
        return $this->cTag;
    }

    public function setCreatedBy(IdentitySet $createdBy = null)
    {
        $this->createdBy = $createdBy;
    }

    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    public function setCreatedDateTime(\DateTimeInterface $createdDateTime = null)
    {
    }

    public function getCreatedDateTime()
    {
    }

    public function setLastModifiedBy(IdentitySet $lastModifiedBy = null)
    {
    }

    public function getLastModifiedBy()
    {
    }

    public function setLastModifiedDateTime(\DateTimeInterface $lastModifiedDateTime = null)
    {
    }

    public function getLastModifiedDateTime()
    {
    }

    public function setSize($size)
    {
    }

    public function getSize()
    {
    }

    public function setWebUrl(UriInterface $webUrl = null)
    {
    }

    public function getWebUrl()
    {
    }

    public function setWebDavUrl(UriInterface $webDavUrl = null)
    {
    }

    public function getWebDavUrl()
    {
    }

    public function setDescription($description)
    {
    }

    public function getDescription()
    {
    }

    public function setParentReference(ItemReference $parentReference = null)
    {
    }

    public function getParentReference()
    {
    }

    public function setFolder(Folder $folder = null)
    {
    }

    public function getFolder()
    {
    }

    public function setFile(File $file = null)
    {
    }

    public function getFile()
    {
    }

    public function setFileSystemInfo(FileSystemInfo $fileSystemInfo = null)
    {
    }

    public function getFileSystemInfo()
    {
    }

    public function setImage(Image $image = null)
    {
    }

    public function getImage()
    {
    }

    public function setPhoto(Photo $photo = null)
    {
    }

    public function getPhoto()
    {
    }

    public function setAudio(Audio $audio = null)
    {
    }

    public function getAudio()
    {
    }

    public function setVideo(Video $video = null)
    {
    }

    public function getVideo()
    {
    }

    public function setLocation(Location $location = null)
    {
    }

    public function getLocation()
    {
    }

    public function setRemoteItem(RemoteItem $remoteItem = null)
    {
    }

    public function getRemoteItem()
    {
    }

    public function setSearchResult(SearchResult $searchResult = null)
    {
    }

    public function getSearchResult()
    {
    }

    public function setDeleted(Deleted $deleted = null)
    {
    }

    public function getDeleted()
    {
    }

    public function setSpecialFolder(SpecialFolder $specialFolder = null)
    {
    }

    public function getSpecialFolder()
    {
    }

    public function setShared(Shared $shared = null)
    {
    }

    public function getShared()
    {
    }

    public function setSharepointIds(SharepointIds $sharepointIds = null)
    {
    }

    public function getSharepointIds()
    {
    }

    public function setRoot(Root $root = null)
    {
    }

    public function getRoot()
    {
    }

    public function setChildren(array $children)
    {
    }

    public function getChildren()
    {
    }

    public function setThumbnails(ThumbnailSet $thumbnails = null)
    {
    }

    public function getThumbnails()
    {
    }

    public function setConflictBehavior($conflictBehavior)
    {
    }

    public function getConflictBehavior()
    {
    }

    public function setDownloadUrl(UriInterface $downloadUrl = null)
    {
    }

    public function getDownloadUrl()
    {
    }

    public function setSourceUrl(UriInterface $sourceUrl = null)
    {
    }

    public function getSourceUrl()
    {
    }

    public function setContent($content)
    {
    }

    public function getContent()
    {
    }
}
