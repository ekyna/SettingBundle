<?php

namespace Ekyna\Bundle\SettingBundle\Entity;

use Ekyna\Bundle\SettingBundle\Model\ParameterInterface;

/**
 * Parameter
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 * @see https://github.com/Sylius/SyliusSettingsBundle/blob/master/Model/Parameter.php
 */
class Parameter implements ParameterInterface
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $namespace;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var \stdClass
     */
    protected $value;


    /**
     * Returns the string representation.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->name ?: 'New parameter';
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set namespace
     *
     * @param string $namespace
     * @return Parameter
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * Get namespace
     *
     * @return string
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Parameter
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set value
     *
     * @param \stdClass $value
     * @return Parameter
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return \stdClass
     */
    public function getValue()
    {
        return $this->value;
    }
}
