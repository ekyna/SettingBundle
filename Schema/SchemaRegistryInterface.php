<?php

declare(strict_types=1);

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
    public function getSchemas(): array;

    /**
     * Register a schema for given settings namespace.
     *
     * @param string          $namespace
     * @param SchemaInterface $schema
     */
    public function registerSchema(string $namespace, SchemaInterface $schema): void;

    /**
     * Unregister schema with given namespace.
     *
     * @param string $namespace
     */
    public function unregisterSchema(string $namespace): void;

    /**
     * Has schema registered to given namespace?
     *
     * @param string $namespace
     *
     * @return bool
     */
    public function hasSchema(string $namespace): bool;

    /**
     * Get schema for given namespace.
     *
     * @param string $namespace
     *
     * @return SchemaInterface
     */
    public function getSchema(string $namespace): SchemaInterface;
}
