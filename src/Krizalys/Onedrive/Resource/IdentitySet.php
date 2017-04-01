<?php

namespace Krizalys\Onedrive\Resource;

class IdentitySet
{
    /**
     * @var null|Identity
     *      The user.
     */
    private $user;

    /**
     * @var null|Identity
     *      The application.
     */
    private $application;

    /**
     * @var null|Identity
     *      The device.
     */
    private $device;

    /**
     * @var null|Identity
     *      The organization.
     */
    private $organization;

    /**
     * @param null|Identity $user
     *        The user.
     * @param null|Identity $application
     *        The application.
     * @param null|Identity $device
     *        The device.
     * @param null|Identity $organization
     *        The organization.
     */
    public function __construct(
        Identity $user = null,
        Identity $application = null,
        Identity $device = null,
        Identity $organization = null
    ) {
        $this->setUser($user);
        $this->setApplication($application);
        $this->setDevice($device);
        $this->setOrganization($organization);
    }

    /**
     * @param null|Identity $user
     *        The user.
     */
    public function setUser(Identity $user = null)
    {
        $this->user = $user;
    }

    /**
     * @return null|Identity
     *         The user.
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param null|Identity $application
     *        The application.
     */
    public function setApplication(Identity $application = null)
    {
        $this->application = $application;
    }

    /**
     * @return null|Identity
     *         The application.
     */
    public function getApplication()
    {
        return $this->application;
    }

    /**
     * @param null|Identity $device
     *        The device.
     */
    public function setDevice(Identity $device = null)
    {
        $this->device = $device;
    }

    /**
     * @return null|Identity
     *         The device.
     */
    public function getDevice()
    {
        return $this->device;
    }

    /**
     * @param null|Identity $organization
     *        The organization.
     */
    public function setOrganization(Identity $organization = null)
    {
        $this->organization = $organization;
    }

    /**
     * @return null|Identity
     *         The organization.
     */
    public function getOrganization()
    {
        return $this->organization;
    }
}
