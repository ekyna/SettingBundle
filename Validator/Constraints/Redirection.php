<?php

namespace Ekyna\Bundle\SettingBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class Redirection
 * @package Ekyna\Bundle\SettingBundle\Validator\Constraints
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class Redirection extends Constraint
{
    public $infiniteLoop        = 'ekyna_setting.redirection.infinite_loop';
    public $badFormat        = 'ekyna_setting.redirection.bad_format';
    public $fromPathExists  = 'ekyna_setting.redirection.from_path_exists';
    public $toPathNotFound = 'ekyna_setting.redirection.to_path_not_found';

    /**
     * {@inheritdoc}
     */
    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }

    /**
     * {@inheritdoc}
     */
    public function validatedBy()
    {
        return 'ekyna_setting_redirection';
    }
}
