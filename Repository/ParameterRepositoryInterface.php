<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Repository;

use Ekyna\Bundle\SettingBundle\Model\ParameterInterface;
use Ekyna\Component\Resource\Repository\ResourceRepositoryInterface;

/**
 * Interface ParameterRepositoryInterface
 * @package Ekyna\Bundle\SettingBundle\Repository
 * @author  Étienne Dauvergne <contact@ekyna.com>
 *
 * @implements ResourceRepositoryInterface<ParameterInterface>
 */
interface ParameterRepositoryInterface extends ResourceRepositoryInterface
{
    /**
     * Finds parameters by namespace.
     *
     * @return array<ParameterInterface>
     */
    public function findByNamespace(string $namespace): array;
}
