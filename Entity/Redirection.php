<?php

namespace Ekyna\Bundle\SettingBundle\Entity;

use Ekyna\Bundle\SettingBundle\Model\RedirectionInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class Redirection
 * @package Ekyna\Bundle\SettingBundle\Entity
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class Redirection implements RedirectionInterface
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
    private $enabled = true;

    /**
     * @var int
     */
    private $count = 0;

    /**
     * @var \DateTime
     */
    private $usedAt;


    /**
     * Returns the string representation.
     *
     * @return string
     */
    public function __toString()
    {
        $from = strlen($this->fromPath) > 16 ? '&hellip;' . substr($this->fromPath, -16) : $this->fromPath;
        $to = strlen($this->toPath) > 16 ? '&hellip;' . substr($this->toPath, -16) : $this->toPath;
        return sprintf('%s &gt; %s', $from, $to);
    }

    /**
     * Returns the id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setFromPath($fromPath)
    {
        $this->fromPath = $fromPath;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getFromPath()
    {
        return $this->fromPath;
    }

    /**
     * {@inheritdoc}
     */
    public function setToPath($toPath)
    {
        $this->toPath = $toPath;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getToPath()
    {
        return $this->toPath;
    }

    /**
     * {@inheritdoc}
     */
    public function setPermanent($permanent)
    {
        $this->permanent = (bool)$permanent;
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPermanent()
    {
        return $this->permanent;
    }

    /**
     * {@inheritdoc}
     */
    public function setEnabled($enabled)
    {
        $this->enabled = (bool)$enabled;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * {@inheritdoc}
     */
    public function setCount($count)
    {
        $this->count = intval($count);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCount()
    {
        return $this->count;
    }

    /**
     * {@inheritdoc}
     */
    public function setUsedAt(\DateTime $usedAt = null)
    {
        $this->usedAt = $usedAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getUsedAt()
    {
        return $this->usedAt;
    }

    /**
     * {@inheritdoc}
     */
    public function getResponse()
    {
        return new RedirectResponse($this->toPath, $this->permanent ? 301 : 302);
    }
}
