<?php

namespace Ekyna\Bundle\SettingBundle\Entity;

use Ekyna\Bundle\CoreBundle\Model\TaggedEntityInterface;

/**
 * Class Helper
 * @package Ekyna\Bundle\SettingBundle\Entity
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class Helper implements TaggedEntityInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $reference;

    /**
     * @var string
     */
    private $content;

    /**
     * @var boolean
     */
    private $enabled;

    /**
     * @var \DateTime
     */
    protected $updatedAt;


    /**
     * Returns the string representation.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
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
     * Sets the name.
     *
     * @param string $name
     * @return Helper
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Returns the name.
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the reference.
     *
     * @param string $reference
     * @return Helper
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Returns the reference.
     *
     * @return string 
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Sets the content.
     *
     * @param string $content
     * @return Helper
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Returns the content.
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Sets whether it is enabled or not.
     *
     * @param boolean $enabled
     * @return Helper
     */
    public function setEnabled($enabled)
    {
        $this->enabled = (bool) $enabled;

        return $this;
    }

    /**
     * Returns whether it is enabled or not.
     *
     * @return boolean 
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Returns the updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Sets the updatedAt.
     *
     * @param \DateTime $updatedAt
     * @return Helper
     */
    public function setUpdatedAt(\DateTime $updatedAt = null)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityTag()
    {
        if (null === $this->getId()) {
            throw new \RuntimeException('Unable to generate http cache tag, as the id property is undefined.');
        }
        return sprintf('ekyna_setting.helper[id:%s]', $this->getId());
    }
}
