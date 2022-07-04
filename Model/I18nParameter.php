<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Model;

use ArrayAccess;
use ArrayIterator;
use IteratorAggregate;
use Serializable;
use Traversable;

use function json_decode;
use function json_encode;

/**
 * Class I18nParameter
 * @package Ekyna\Bundle\SettingBundle\Model
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
final class I18nParameter implements ArrayAccess, IteratorAggregate, Serializable
{
    private string $currentLocale;
    private string $fallbackLocale;

    public function __construct(private array $data = [])
    {
    }

    /**
     * Returns the string representation.
     */
    public function __toString(): string
    {
        return $this->trans() ?: 'New I18n parameter';
    }

    public function __get(string $name): mixed
    {
        return $this->data[$name] ?? null;
    }

    public function __set(string $name, mixed $value): void
    {
        $this->data[$name] = $value;
    }

    public function setCurrentLocale(string $locale): void
    {
        $this->currentLocale = $locale;
    }

    public function setFallbackLocale(string $locale): void
    {
        $this->fallbackLocale = $locale;
    }

    /**
     * Translate the parameter.
     */
    public function trans(string $locale = null): ?string
    {
        return $this->data[$locale ?? $this->currentLocale]
            ?? $this->data[$this->fallbackLocale]
            ?? null;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->data ?? []);
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->data[$offset];
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->data[$offset]);
    }

    public function serialize(): ?string
    {
        return json_encode($this->__serialize());
    }

    public function __serialize(): array
    {
        return $this->data;
    }

    public function unserialize(string $data): void
    {
        $this->data = (array)json_decode($data, true);
    }

    public function __unserialize(array $data): void
    {
        $this->data = $data;
    }
}
