<?php

declare(strict_types=1);

namespace Ekyna\Bundle\SettingBundle\Event;

/**
 * Class RedirectionEvents
 * @package Ekyna\Bundle\SettingBundle\Event
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
final class RedirectionEvents
{
    public const BUILD   = 'ekyna_setting.redirection.build';
    public const DISCARD = 'ekyna_setting.redirection.discard';

    private function __construct()
    {
    }
}
