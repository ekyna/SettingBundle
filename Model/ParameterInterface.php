<?php

namespace Ekyna\Bundle\SettingBundle\Model;

/**
 * Interface ParameterInterface
 * @package Ekyna\Bundle\SettingBundle\Model
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
interface ParameterInterface
{
    /**
     * Get id
     *
     * @return int|null
     */
    public function getId(): ?int;

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
