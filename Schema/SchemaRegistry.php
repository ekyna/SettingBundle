<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Schema;

use InvalidArgumentException;

use function sprintf;

/**
 * Class SchemaRegistry
 * @package Ekyna\Bundle\SettingBundle\Schema
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class SchemaRegistry implements SchemaRegistryInterface
{
    /** @var SchemaInterface[] */
    protected array $schemas;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->schemas = [];
    }

    /**
     * @inheritDoc
     */
    public function getSchemas(): array
    {
        return $this->schemas;
    }

    /**
     * @inheritDoc
     */
    public function registerSchema(string $namespace, SchemaInterface $schema): void
    {
        if (!$this->hasSchema($namespace)) {
            $this->schemas[$namespace] = $schema;

            return;
        }

        throw new InvalidArgumentException(sprintf(
            'Schema with namespace "%s" has been already registered',
            $namespace
        ));
    }

    /**
     * @inheritDoc
     */
    public function unregisterSchema(string $namespace): void
    {
        if ($this->hasSchema($namespace)) {
            unset($this->schemas[$namespace]);

            return;
        }

        throw new InvalidArgumentException(sprintf(
            'Schema with namespace "%s" does not exist',
            $namespace
        ));
    }

    /**
     * @inheritDoc
     */
    public function hasSchema($namespace): bool
    {
        return isset($this->schemas[$namespace]);
    }

    /**
     * @inheritDoc
     */
    public function getSchema($namespace): SchemaInterface
    {
        if ($this->hasSchema($namespace)) {
            return $this->schemas[$namespace];
        }

        throw new InvalidArgumentException(sprintf(
            'Schema with namespace "%s" does not exist',
            $namespace
        ));
    }
}
