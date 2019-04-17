<?php

namespace Ekyna\Bundle\SettingBundle\Schema;

/**
 * Interface SchemaRegistryInterface
 * @package Ekyna\Bundle\SettingBundle\Schema
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
interface SchemaRegistryInterface
{
    /**
     * Get an array of all registered schemas.
     *
     * @return SchemaInterface[]
     */
    public function getSchemas();

    /**
     * Register a schema for given settings namespace.
     *
     * @param string          $namespace
     * @param SchemaInterface $schema
     */
    public function registerSchema($namespace, SchemaInterface $schema);

    /**
     * Unregister schema with given namespace.
     *
     * @param string $namespace
     */
    public function unregisterSchema($namespace);

    /**
     * Has schema registered to given namespace?
     *
     * @param string $namespace
     *
     * @return Boolean
     */
    public function hasSchema($namespace);

    /**
     * Get schema for given namespace.
     *
     * @param string $namespace
     *
     * @return SchemaInterface
     */
    public function getSchema($namespace);
}
