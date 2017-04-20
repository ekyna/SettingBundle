<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Event;

/**
 * Class ParameterEvents
 * @package Ekyna\Bundle\SettingBundle\Event
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
final class ParameterEvents
{
    public const UPDATE = 'ekyna_setting.parameter.update';

    private function __construct()
    {
    }
}
