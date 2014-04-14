<?php

namespace Ekyna\Bundle\SettingBundle\Entity;

use Doctrine\Common\Persistence\ObjectRepository;

/**
 * ParameterRepositoryInterface
 *
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
