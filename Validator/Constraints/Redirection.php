<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class Redirection
 * @package Ekyna\Bundle\SettingBundle\Validator\Constraints
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class Redirection extends Constraint
{
    public string $infiniteLoop   = 'ekyna_setting.redirection.infinite_loop';
    public string $badFormat      = 'ekyna_setting.redirection.bad_format';
    public string $fromPathExists = 'ekyna_setting.redirection.from_path_exists';
    public string $toPathNotFound = 'ekyna_setting.redirection.to_path_not_found';


    /**
     * @inheritDoc
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
