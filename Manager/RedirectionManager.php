<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Manager;

use Ekyna\Component\Resource\Doctrine\ORM\Manager\ResourceManager;

/**
 * Class RedirectionManager
 * @package Ekyna\Bundle\SettingBundle\Manager
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class RedirectionManager extends ResourceManager implements RedirectionManagerInterface
{
    /**
     * Discards the redirections.
     *
     * @param array $paths
     */
    public function discardRedirections(array $paths): void
    {
        $qb = $this->wrapped->createQueryBuilder();

        $qb
            ->delete($this->resourceClass, 'r')
            ->where($qb->expr()->in('r.fromPath', ':paths'))
            ->getQuery()
            ->setParameter('paths', $paths)
            ->execute();
    }
}
