<?php

namespace Ekyna\Bundle\SettingBundle\Entity;

/**
 * ParameterInterface
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@sylius.pl>
 * @see https://github.com/Sylius/SyliusSettingsBundle/blob/master/Model/ParameterInterface.php
 */
interface ParameterInterface
{
    /**
     * Get settings namespace.
     *
     * @return string
     */
    public function getNamespace();

    /**
     * Set settings namespace.
     *
     * @param string $namespace
     */
    public function setNamespace($namespace);

    /**
     * Get parameter name.
     *
     * @return string
     */
    public function getName();

    /**
     * Set parameter name.
     *
     * @param string $name
     */
    public function setName($name);

    /**
     * Get value.
     *
     * @return mixed
     */
    public function getValue();

    /**
     * Set parameter value.
     *
     * @param mixed $value
     */
    public function setValue($value);
}
