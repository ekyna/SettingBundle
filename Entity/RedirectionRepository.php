<?php

namespace Ekyna\Bundle\SettingBundle\Entity;

use Ekyna\Bundle\AdminBundle\Doctrine\ORM\ResourceRepository;


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
            ->setParameters(array(
                'path' => $path,
                'enabled' => true,
            ))
            ->getOneOrNullResult()
        ;
    }
}
