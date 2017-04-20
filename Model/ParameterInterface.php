<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Model;

use Ekyna\Component\Resource\Model\ResourceInterface;

/**
 * Interface ParameterInterface
 * @package Ekyna\Bundle\SettingBundle\Model
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
interface ParameterInterface extends ResourceInterface
{
    /**
     * Returns the parameter namespace.
     *
     * @return string|null
     */
    public function getNamespace(): ?string;

    /**
     * Sets the parameter namespace.
     *
     * @param string $namespace
     *
     * @return $this|ParameterInterface
     */
    public function setNamespace(string $namespace): ParameterInterface;

    /**
     * Returns the parameter name.
     *
     * @return string|null
     */
    public function getName(): ?string;

    /**
     * Sets the parameter name.
     *
     * @param string $name
     *
     * @return $this|ParameterInterface
     */
    public function setName(string $name): ParameterInterface;

    /**
     * Returns the parameter value.
     *
     * @return mixed
     */
    public function getValue();

    /**
     * Sets the parameter value.
     *
     * @param mixed $value
     *
     * @return $this|ParameterInterface
     */
    public function setValue($value): ParameterInterface;
}
