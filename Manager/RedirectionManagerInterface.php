<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Manager;

use Ekyna\Component\Resource\Manager\ResourceManagerInterface;

/**
 * Interface RedirectionManagerInterface
 * @package Ekyna\Bundle\SettingBundle\Manager
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
interface RedirectionManagerInterface extends ResourceManagerInterface
{
    /**
     * Discards the redirections.
     *
     * @param array $paths
     */
    public function discardRedirections(array $paths): void;
}
