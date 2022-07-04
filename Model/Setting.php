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
final class Setting implements ArrayAccess
{
    public function __construct(protected array $parameters)
    {
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

    public function setParameters(array $parameters): void
    {
        $this->parameters = $parameters;
    }

    /**
     * Returns whether this setting has a parameter by its name.
     */
    public function has(string $name): bool
    {
        return array_key_exists($name, $this->parameters);
    }

    /**
     * Returns the parameter by its name.
     */
    public function get(string $name): mixed
    {
        if (!$this->has($name)) {
            throw new InvalidArgumentException(sprintf('Parameter with name "%s" does not exist.', $name));
        }

        return $this->parameters[$name];
    }

    public function set(string $name, mixed $value): void
    {
        $this->parameters[$name] = $value;
    }

    public function remove(string $name): void
    {
        if (!$this->has($name)) {
            throw new InvalidArgumentException(sprintf('Parameter with name "%s" does not exist.', $name));
        }

        unset($this->parameters[$name]);
    }

    public function offsetExists(mixed $offset): bool
    {
        return $this->has($offset);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->get($offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->set($offset, $value);
    }

    public function offsetUnset(mixed $offset): void
    {
        $this->remove($offset);
    }

    public function merge(Setting $settings): void
    {
        foreach ($settings as $name => $value) {
            $this->set($name, $value);
        }
    }
}
