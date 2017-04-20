<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Model;

use ArrayAccess;
use InvalidArgumentException;

use function sprintf;

/**
 * Class Settings
 * @package Ekyna\Bundle\SettingBundle\Model
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
final class Settings implements ArrayAccess
{
    protected array $parameters;

    /**
     * Constructor.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    /**
     * Returns the parameters.
     *
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * Sets the parameters.
     *
     * @param array $parameters
     */
    public function setParameters(array $parameters): void
    {
        $this->parameters = $parameters;
    }

    /**
     * Returns whether this settings has a parameter by its name.
     *
     * @param string $name
     *
     * @return bool
     */
    public function has(string $name): bool
    {
        return array_key_exists($name, $this->parameters);
    }

    /**
     * Returns the parameter by its name.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function get(string $name)
    {
        if (!$this->has($name)) {
            throw new InvalidArgumentException(sprintf('Parameter with name "%s" does not exist.', $name));
        }

        return $this->parameters[$name];
    }

    /**
     * Sets the parameter.
     *
     * @param string $name
     * @param mixed  $value
     */
    public function set(string $name, $value): void
    {
        $this->parameters[$name] = $value;
    }

    /**
     * Removes the parameter by its name.
     *
     * @param string $name
     */
    public function remove(string $name): void
    {
        if (!$this->has($name)) {
            throw new InvalidArgumentException(sprintf('Parameter with name "%s" does not exist.', $name));
        }

        unset($this->parameters[$name]);
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset): bool
    {
        return $this->has($offset);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value): void
    {
        $this->set($offset, $value);
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset): void
    {
        $this->remove($offset);
    }

    /**
     * Merges the settings.
     *
     * @param Settings $settings
     */
    public function merge(Settings $settings): void
    {
        foreach ($settings as $name => $value) {
            $this->set($name, $value);
        }
    }
}
