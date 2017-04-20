<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Repository;

use Ekyna\Bundle\SettingBundle\Model\RedirectionInterface;
use Ekyna\Component\Resource\Doctrine\ORM\Repository\ResourceRepository;

/**
 * Class RedirectionRepository
 * @package Ekyna\Bundle\SettingBundle\Entity
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class RedirectionRepository extends ResourceRepository implements RedirectionRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function findOneByFrom(string $path): ?RedirectionInterface
    {
        $qb = $this->createQueryBuilder('r');

        /** @noinspection PhpUnhandledExceptionInspection */
        return $qb
            ->andWhere($qb->expr()->eq('r.fromPath', ':path'))
            ->andWhere($qb->expr()->eq('r.enabled', ':enabled'))
            ->getQuery()
            ->setMaxResults(1)
            ->setParameters([
                'path'    => $path,
                'enabled' => true,
            ])
            ->getOneOrNullResult();
    }

    /**
     * @inheritDoc
     */
    public function findByFromOrTo(string $path): array
    {
        $qb = $this->createQueryBuilder('r');

        return $qb
            ->andWhere($qb->expr()->orX(
                $qb->expr()->eq('r.fromPath', ':from'),
                $qb->expr()->eq('r.toPath', ':from')
            ))
            ->getQuery()
            ->setParameter('from', $path)
            ->getResult();
    }
}
