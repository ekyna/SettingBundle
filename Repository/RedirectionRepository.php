<?php

namespace Ekyna\Bundle\SettingBundle\Repository;

use Ekyna\Bundle\SettingBundle\Entity\Redirection;
use Ekyna\Component\Resource\Doctrine\ORM\ResourceRepository;

/**
 * Class RedirectionRepository
 * @package Ekyna\Bundle\SettingBundle\Entity
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class RedirectionRepository extends ResourceRepository
{
    /**
     * Finds the redirection by "from path".
     *
     * @param string $path
     * @return Redirection|null
     */
    public function findByPath($path)
    {
        $qb = $this->createQueryBuilder('r');

        $query = $qb
            ->andWhere($qb->expr()->eq('r.fromPath', ':path'))
            ->andWhere($qb->expr()->eq('r.enabled', ':enabled'))
            ->getQuery()
            ->setMaxResults(1)
            // TODO cache
        ;

        return $query
            ->setParameters([
                'path' => $path,
                'enabled' => true,
            ])
            ->getOneOrNullResult()
        ;
    }
}