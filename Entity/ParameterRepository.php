<?php

namespace Ekyna\Bundle\SettingBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ParameterRepository
 *
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class ParameterRepository extends EntityRepository implements ParameterRepositoryInterface
{
    public function createNew()
    {
        $class = $this->getClassName();

        return new $class;
    }
}
