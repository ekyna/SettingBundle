<?php

namespace Ekyna\Bundle\SettingBundle\Entity;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class Redirection
 * @package Ekyna\Bundle\SettingBundle\Entity
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class Redirection
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $fromPath;

    /**
     * @var string
     */
    private $toPath;

    /**
     * @var bool
     */
    private $permanent = false;

    /**
     * @var boolean
     */
    private $enabled;


    /**
     * Returns the string representation.
     *
     * @return string
     */
    public function __toString()
    {
        $from = strlen($this->fromPath) > 16 ? '&hellip;'.substr($this->fromPath, -16) : $this->fromPath;
        $to = strlen($this->toPath) > 16 ? '&hellip;'.substr($this->toPath, -16) : $this->toPath;
        return sprintf('%s &gt; %s', $from, $to);
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set fromPath
     *
     * @param string $fromPath
     * @return Redirection
     */
    public function setFromPath($fromPath)
    {
        $this->fromPath = $fromPath;

        return $this;
    }

    /**
     * Get fromPath
     *
     * @return string 
     */
    public function getFromPath()
    {
        return $this->fromPath;
    }

    /**
     * Set toPath
     *
     * @param string $toPath
     * @return Redirection
     */
    public function setToPath($toPath)
    {
        $this->toPath = $toPath;

        return $this;
    }

    /**
     * Get toPath
     *
     * @return string 
     */
    public function getToPath()
    {
        return $this->toPath;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     * @return Redirection
     */
    public function setEnabled($enabled)
    {
        $this->enabled = (bool) $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Sets the permanent.
     *
     * @param boolean $permanent
     * @return Redirection
     */
    public function setPermanent($permanent)
    {
        $this->permanent = (bool) $permanent;
        return $this;
    }

    /**
     * Returns the permanent.
     *
     * @return boolean
     */
    public function getPermanent()
    {
        return $this->permanent;
    }

    /**
     * Returns the redirect response.
     *
     * @return RedirectResponse
     */
    public function getResponse()
    {
        return new RedirectResponse($this->toPath, $this->permanent ? 301 : 302);
    }
}
