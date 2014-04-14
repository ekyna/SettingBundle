<?php

namespace Ekyna\Bundle\SettingBundle\Entity;

/**
 * Parameter
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 * @see https://github.com/Sylius/SyliusSettingsBundle/blob/master/Model/Parameter.php
 */
class Parameter implements ParameterInterface
{
    /**
     * @var integer
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


    public function __toString()
    {
        return $this->getName();
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
