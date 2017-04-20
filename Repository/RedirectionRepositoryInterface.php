<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Repository;

use Ekyna\Bundle\SettingBundle\Model\RedirectionInterface;
use Ekyna\Component\Resource\Repository\ResourceRepositoryInterface;

/**
 * Interface RedirectionRepositoryInterface
 * @package Ekyna\Bundle\SettingBundle\Repository
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
interface RedirectionRepositoryInterface extends ResourceRepositoryInterface
{
    /**
     * Finds one enabled redirection with the given path as 'from'.
     *
     * @param string $path
     *
     * @return RedirectionInterface|null
     */
    public function findOneByFrom(string $path): ?RedirectionInterface;

    /**
     * Finds the redirections having the given path either as 'from' or 'to' .
     *
     * @param string $path
     *
     * @return RedirectionInterface[]
     */
    public function findByFromOrTo(string $path): array;
}