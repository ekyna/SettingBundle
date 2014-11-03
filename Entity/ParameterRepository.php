<?php

namespace Ekyna\Bundle\SettingBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Class ParameterRepository
 * @package Ekyna\Bundle\SettingBundle\Entity
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
