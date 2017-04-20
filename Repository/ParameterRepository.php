<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Repository;

use Ekyna\Component\Resource\Doctrine\ORM\Repository\ResourceRepository;

/**
 * Class ParameterRepository
 * @package Ekyna\Bundle\SettingBundle\Entity
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class ParameterRepository extends ResourceRepository implements ParameterRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function findByNamespace(string $namespace): array
    {
        $qb = $this->createQueryBuilder('p');

        return $qb
            ->andWhere($qb->expr()->eq('p.namespace', ':namespace'))
            ->getQuery()
            ->setParameter('namespace', $namespace)
            ->getResult();
    }
}
