<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Entity;

use Ekyna\Bundle\SettingBundle\Model\ParameterInterface;
use Ekyna\Component\Resource\Model\AbstractResource;

/**
 * Class Parameter
 * @package Ekyna\Bundle\SettingBundle\Entity
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class Parameter extends AbstractResource implements ParameterInterface
{
    protected ?string $namespace = null;
    protected ?string $name      = null;
    protected         $value;


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
     * @inheritDoc
     */
    public function setNamespace(string $namespace): ParameterInterface
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getNamespace(): ?string
    {
        return $this->namespace;
    }

    /**
     * @inheritDoc
     */
    public function setName(string $name): ParameterInterface
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function setValue($value): ParameterInterface
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getValue()
    {
        return $this->value;
    }
}
