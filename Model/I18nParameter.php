<?php

namespace Ekyna\Bundle\SettingBundle\Model;

/**
 * Class I18nParameter
 * @package Ekyna\Bundle\SettingBundle\Model
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class I18nParameter implements \ArrayAccess, \IteratorAggregate, \Serializable
{
    /**
     * @var array
     */
    private $data;

    /**
     * @var string
     */
    private $currentLocale;

    /**
     * @var string
     */
    private $fallbackLocale;


    /**
     * Constructor.
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * Returns the string representation.
     *
     * @return string
     */
    public function __toString(): string
    {
        return $this->trans() ?: 'New I18n parameter';
    }

    /**
     * @inheritDoc
     */
    public function __get($name)
    {
        return $this->data[$name] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * Sets the current locale.
     *
     * @param string $locale
     */
    public function setCurrentLocale(string $locale): void
    {
        $this->currentLocale = $locale;
    }

    /**
     * Sets the fallback locale.
     *
     * @param string $locale
     */
    public function setFallbackLocale(string $locale): void
    {
        $this->fallbackLocale = $locale;
    }

    /**
     * Translate the parameter.
     *
     * @param string|null $locale
     *
     * @return string|null
     */
    public function trans(string $locale = null): ?string
    {
        return $this->data[$locale ?? $this->currentLocale]
            ?? $this->data[$this->fallbackLocale]
            ?? null;
    }

    /**
     * @inheritDoc
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->data ?? []);
    }

    /**
     * @inheritDoc
     */
    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    /**
     * @inheritDoc
     */
    public function offsetGet($offset)
    {
        return $this->data[$offset];
    }

    /**
     * @inheritDoc
     */
    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;
    }

    /**
     * @inheritDoc
     */
    public function offsetUnset($offset)
    {
        unset($this->data);
    }

    /**
     * @inheritDoc
     */
    public function serialize()
    {
        return \json_encode($this->data);
    }

    /**
     * @inheritDoc
     */
    public function unserialize($data)
    {
        $this->data = \json_decode($data, true);
    }
}
