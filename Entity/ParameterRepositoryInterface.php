<?php

namespace Ekyna\Bundle\SettingBundle\Entity;

use Doctrine\Common\Persistence\ObjectRepository;

/**
 * Interface ParameterRepositoryInterface
 * @package Ekyna\Bundle\SettingBundle\Entity
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
interface ParameterRepositoryInterface extends ObjectRepository
{
    /**
     * Returns a new parameter
     * 
     * @return Parameter
     */
    public function createNew();
}
